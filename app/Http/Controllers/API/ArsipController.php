<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Arsip;
use App\Surat;
use App\Box;
use App\Retensi;
use Carbon\Carbon;
use QRCode;
use App\Http\Requests\FormArsipRequest;

class ArsipController extends Controller
{
    public function __construct() {
        $this->middleware('can:isMasterOrAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arsip = Arsip::latest()->where('status_retensi', 0)->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
            'surat.skpd:id_skpd,kode_skpd,nama_skpd',
            'surat.jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d',
            'box:id_box,id_rak,kode_box',
            'box.rak:id_rak,id_ruangan,kode_rak',
            'box.rak.ruangan:id_ruangan,id_gedung,kode_ruangan',
            'box.rak.ruangan.gedung:id_gedung,nama_gedung'
        ])->get()->paginateCollection(10);

        return response()->json([
            'data' => $arsip
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormArsipRequest $request)
    {
        $date = Carbon::parse($request->tgl_diarsipkan);
        $arsipDate = $date->toDateTimeString();
        $retensiDate = $date->addYears(10)->toDateTimeString();

        $request->merge([
            'tgl_diarsipkan' => $arsipDate,
            'tgl_perkiraan_retensi' => $retensiDate
        ]);

        $arsip = Arsip::create($request->except(['nomor_surat']));

        // Update jumlah arsip dalam box
        $box = Box::findOrFail($request->id_box);
        $box->increment('jml_arsip', 1);
        
        // Update surat menjadi arsip
        $surat = Surat::findOrFail($request->id_sp2d);
        $surat->update(['arsip' => 1]);

        return $this->generateArsipQr($arsip, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormArsipRequest $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $date = Carbon::parse($request->tgl_diarsipkan);
        $arsipDate = $date->toDateTimeString();

        if ($arsipDate != $arsip->tgl_diarsipkan) {
            $retensiDate = $date->addYears(10)->toDateTimeString();
        }else {
            $retensiDate = $arsip->tgl_perkiraan_retensi;
        }

        $request->merge([
            'tgl_diarsipkan' => $arsipDate,
            'tgl_perkiraan_retensi' => $retensiDate
        ]);

        $arsip->update($request->except(['nomor_surat']));

        return $this->generateArsipQr($arsip, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arsip = Arsip::findOrFail($id);
        $arsip->update(['status_retensi' => 1]);

        // Update jumlah arsip dalam box
        $box = Box::findOrFail($arsip->id_box);
        $box->decrement('jml_arsip', 1);

        @unlink(public_path('img/qr/arsip/'.$arsip->qr_arsip));

        return response()->json([
            'message' => 'Arsip : '.$arsip->surat->nomor_surat.' telah diretensi'
        ]);
    }

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $arsip = Arsip::with([
                'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
                'surat.skpd:id_skpd,kode_skpd,nama_skpd',
                'surat.jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d',
                'box:id_box,id_rak,kode_box',
                'box.rak:id_rak,id_ruangan,kode_rak',
                'box.rak.ruangan:id_ruangan,id_gedung,kode_ruangan',
                'box.rak.ruangan.gedung:id_gedung,nama_gedung'
            ])->whereHas('surat', function($query) use ($keywords) {
                $query->where('nomor_surat', 'LIKE', "%$keywords%");
            })->where('status_retensi', 0)->get()->paginateCollection(10);
        }

        return response()->json([
            'data' => $arsip
        ]);
    }

    public function generateArsipQr($arsip, $request)
    {
        $letak = Arsip::join('surats', 'surats.id_sp2d', '=', 'arsips.id_sp2d')
                        ->join('boxes', 'boxes.id_box', '=', 'arsips.id_box')
                        ->join('raks', 'raks.id_rak', '=', 'boxes.id_rak')
                        ->join('ruangans', 'ruangans.id_ruangan', '=', 'raks.id_ruangan')
                        ->join('gedungs', 'gedungs.id_gedung', '=', 'ruangans.id_gedung')
                        ->select('nama_gedung', 'kode_ruangan', 'kode_rak', 'kode_box', 'nomor_surat')
                        ->where(['arsips.id_arsip' => $arsip->id_arsip, 'arsips.status' => 1])
                        ->get()->first();
        
        $currentArsipQr = $arsip->qr_arsip;
        $filename = str_replace('/', '-', $letak['nomor_surat']).'-'.time().'.png';
        $path = public_path('img/qr/arsip/'.$filename);
        QRCode::text(
            'Gedung : '.$letak['nama_gedung'].' / '.
            'Ruangan : '.$letak['kode_ruangan'].' / '.
            'Rak : '.$letak['kode_rak'].' / '.
            'Box : '.$letak['kode_box'].' / '.
            'Nomor Surat : '.$letak['nomor_surat'])
                ->setSize(10)
                ->setMargin(1)
                ->setOutFile($path)
                ->png();

        $arsip->update(['qr_arsip' => $filename]);

        if ($request->isMethod('POST')) {
            return response()->json([
                'data' => $arsip,
                'message' => 'Surat dengan nomor: '.$request->nomor_surat.' telah diarsipkan'
            ]);
        }else if ($request->isMethod('PUT')) {
            @unlink(public_path('img/qr/arsip/'.$currentArsipQr));

            return response()->json([
                'data' => $arsip,
                'message' => 'Arsip '.$request->nomor_surat.' telah diperbarui'
            ]);
        }
    }
}
