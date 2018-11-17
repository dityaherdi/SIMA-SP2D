<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Surat;
use App\Http\Requests\FormSuratRequest;
use Carbon\Carbon;

class SuratController extends Controller
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
        $surat = Surat::latest()->with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0])->get()->paginateCollection(16);

        return response()->json([
            'data' => $surat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSuratRequest $request)
    {
        $date = Carbon::parse($request->tgl_terbit)->toDateTimeString();
        $request->merge(['tgl_terbit' => $date]);
        
        $surat = Surat::Create($request->all());

        return response()->json([
            'data' => $surat,
            'message' => 'SP2D dengan nomor surat: '.$request->nomor_surat.' ditambahkan'
        ]);
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
    public function update(FormSuratRequest $request, $id)
    {
        $date = Carbon::parse($request->tgl_terbit)->toDateTimeString();
        $request->merge(['tgl_terbit' => $date]);

        $surat = Surat::findOrFail($id);
        $surat->update($request->all());

        return response()->json([
            'message' => 'SP2D dengan nomor surat: '.$request->nomor_surat.' telah diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete();

        return response()->json([
            'data' => $surat,
            'message' => 'SP2D dengan nomor surat: '.$surat->nomor_surat.' telah dihapus'
        ]);
    }

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $surat = Surat::whereHas('skpd', function($query) use ($keywords) {
                $query->where('nomor_surat', 'LIKE', "%$keywords%")
                        ->orWhere('tgl_terbit', 'LIKE', "%$keywords%")
                        ->orWhere('nama_skpd', 'LIKE', "%$keywords%")
                        ->orWhere('alias_skpd', 'LIKE', "%$keywords%")
                        ->orWhere('kode_skpd', 'LIKE', "%$keywords%");
            })->with([
                'skpd:id_skpd,kode_skpd,nama_skpd',
                'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
            ])->where(['arsip' => 0])->get()->paginateCollection(16);
        }

        return response()->json([
            'data' => $surat
        ]);
    }

    public function sortBySkpd($id)
    {
        $surat = Surat::with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0, 'id_skpd' => $id])->get()->paginateCollection(16);

        return response()->json([
            'data' => $surat
        ]);   
    }
    
}
