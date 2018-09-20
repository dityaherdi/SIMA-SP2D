<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormGedungRequest;
use App\Gedung;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gedung::latest()->paginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormGedungRequest $request)
    {
        $gedung = Gedung::Create($request->all());

        return response()->json([
            'data' => $gedung,
            'message' => 'Gedung dengan kode: '.$request->kode_gedung.' ditambahkan'
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
    public function update(Request $request, $id)
    {
        $gedung = Gedung::findOrFail($id);
        $gedung->update($request->all());

        return response()->json([
            'data' => $gedung,
            'message' => 'Gedung dengan kode: '.$gedung->kode_gedung.' telah diperbarui'
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
        $gedung = Gedung::findOrFail($id);
        $gedung->delete();

        return response()->json([
            'data' => $gedung,
            'message' => 'Gedung dengan kode: '.$gedung->kode_gedung.' telah dihapus'
        ]);
    }

    public function getGedung()
    {
        $gedung = Gedung::select('id_gedung', 'kode_gedung', 'nama_gedung')->where('status', 1)->get();

        return response()->json([
            'data' => $gedung
        ]);
    }
}
