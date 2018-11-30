<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormRuanganRequest;
use App\Ruangan;
use DB;

class RuanganController extends Controller
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
        $ruangan = Ruangan::latest()->with('gedung:id_gedung,nama_gedung')->get()->paginateCollection(10);

        return response()->json([
            'data' => $ruangan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRuanganRequest $request)
    {
        $ruangan = Ruangan::Create($request->all());

        return response()->json([
            'data' => $ruangan,
            'message' => 'Ruangan dengan kode: '.$request->kode_ruangan.' ditambahkan'
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
    public function update(FormRuanganRequest $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());

        return response()->json([
            'data' => $ruangan,
            'message' => 'Ruangan dengan kode: '.$ruangan->kode_ruangan.' telah diperbarui'
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
        // $ruangan = Ruangan::findOrFail($id);
        // $ruangan->delete();

        // return response()->json([
        //     'data' => $ruangan,
        //     'message' => 'Ruangan dengan kode: '.$ruangan->kode_ruangan.' telah dihapus'
        // ]);
    }

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $ruangan = Ruangan::where(function($query) use ($keywords) {
                $query->where('kode_ruangan', 'LIKE', "%$keywords%");
            })->with('gedung:id_gedung,nama_gedung')->get()->paginateCollection(5);
        }

        return response()->json([
            'data' => $ruangan
        ]);
    }

    public function ruanganInGedung($id)
    {
        $ruangan = Ruangan::where('id_gedung', $id)->with('gedung:id_gedung,nama_gedung')
                            ->orderBy('kode_ruangan', 'ASC')
                            ->get()->paginateCollection(10);

        return response()->json([
            'data' => $ruangan
        ]);
    }
}