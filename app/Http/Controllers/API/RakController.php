<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rak;
use App\Http\Requests\FormRakRequest;
use QRCode;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');
        // $rak = Rak::latest()->with('ruangan:id_ruangan,kode_ruangan.gedung:id_gedung,nama_gedung')->get();
        $rak = Rak::latest()->with([
            'ruangan:id_ruangan,id_gedung,kode_ruangan',
            'ruangan.gedung:id_gedung,nama_gedung'
        ])->get()->paginateCollection(3);

        return response()->json([
            'data' => $rak
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRakRequest $request)
    {
        $rak = Rak::Create($request->all());

        return $this->generateRakQr($rak, $request);
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
    public function update(FormRakRequest $request, $id)
    {
        $rak = Rak::findOrFail($id);
        $rak->update($request->all());

        return $this->generateRakQr($rak, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();
        @unlink(public_path('img/qr/rak/'.$rak->qr_rak));

        return response()->json([
            'data' => $rak,
            'message' => 'Rak dengan kode: '.$rak->kode_rak.' telah dihapus'
        ]);
    }

    public function generateRakQr($rak, $request)
    {
        $letak = Rak::join('ruangans', 'ruangans.id_ruangan', '=', 'raks.id_ruangan')
                        ->join('gedungs', 'gedungs.id_gedung', '=', 'ruangans.id_gedung')
                        ->select('nama_gedung', 'kode_ruangan', 'kode_rak')
                        ->where(['raks.id_rak' => $rak->id_rak, 'raks.status' => 1])
                        ->get()->first();

        $currentRakQr = $rak->qr_rak;
        $filename = str_slug($letak['kode_rak']).'.png';
        $path = public_path('img/qr/rak/'.$filename);
        QRCode::text(
            'Gedung : '.$letak['nama_gedung'].' / '.
            'Ruang : '.$letak['kode_ruangan'].' / '.
            'Rak : '.$letak['kode_rak'])
                ->setSize(10)
                ->setMargin(1)
                ->setOutFile($path)
                ->png();
        $rak->update(['qr_rak' => $filename]);

        if ($request->isMethod('POST')) {
            return response()->json([
                'data' => $rak,
                'message' => 'Rak dengan kode: '.$rak->kode_rak.' ditambahkan'
            ]);
        }else if ($request->isMethod('PUT')) {
            @unlink(public_path('img/qr/rak/'.$currentRakQr));

            return response()->json([
                'data' => $rak,
                'message' => 'Rak dengan kode: '.$rak->kode_rak.' telah diperbarui'
            ]);
        }
    }
}