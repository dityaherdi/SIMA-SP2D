<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rak;
use App\Http\Requests\FormRakRequest;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $rak = Rak::latest()->with('ruangan:id_ruangan,kode_ruangan.gedung:id_gedung,nama_gedung')->get();
        $rak = Rak::latest()->with([
            'ruangan' => function($query) {
                $query->select('id_ruangan', 'id_gedung', 'kode_ruangan');
            },
            'ruangan.gedung' => function($query) {
                $query->select('id_gedung', 'nama_gedung');
            }
        ])->get();

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

        return response()->json([
            'data' => $rak,
            'message' => 'Rak dengan kode: '.$rak->kode_rak.' ditambahkan'
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
    public function update(FormRakRequest $request, $id)
    {
        $rak = Rak::findOrFail($id);
        $rak->update($request->all());

        return response()->json([
            'data' => $rak,
            'message' => 'Rak dengan kode: '.$rak->kode_rak.' telah diperbarui'
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
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return response()->json([
            'data' => $rak,
            'message' => 'Rak dengan kode: '.$rak->kode_rak.' telah dihapus'
        ]);
    }
}
