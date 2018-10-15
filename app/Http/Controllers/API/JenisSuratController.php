<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormJenisRequest;
use App\JenisSurat;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis = JenisSurat::latest()->paginate(4);

        return response()->json([
            'data' => $jenis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormJenisRequest $request)
    {
        $jenis = JenisSurat::Create($request->all());

        return response()->json([
            'data' => $jenis,
            'message' => 'Jenis SP2D '.$request->kode_jenis_sp2d.' ditambahkan'
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
    public function update(FormJenisRequest $request, $id)
    {
        $jenis = JenisSurat::findOrFail($id);
        $jenis->update($request->all());

        return response()->json([
            'data' => $jenis,
            'message' => 'Jenis SP2D '.$jenis->kode_jenis_sp2d.' telah diperbarui'
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
        $jenis = JenisSurat::findOrFail($id);
        $jenis->delete();

        return response()->json([
            'data' => $jenis,
            'message' => 'Jenis SP2D '.$jenis->nama_jenis_sp2d.' telah dihapus'
        ]);
    }
}
