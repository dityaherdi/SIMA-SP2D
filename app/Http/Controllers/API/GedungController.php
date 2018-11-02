<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormGedungRequest;
use App\Gedung;

class GedungController extends Controller
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
        $gedung = Gedung::latest()->paginate(5);

        return response()->json([
            'data' => $gedung
        ]);
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

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $gedung = Gedung::where(function($query) use ($keywords) {
                $query->where('kode_gedung', 'LIKE', "%$keywords%")
                        ->orWhere('nama_gedung', 'LIKE', "%$keywords%");
            })->paginate(5);
        }

        return response()->json([
            'data' => $gedung
        ]);
    }
}
