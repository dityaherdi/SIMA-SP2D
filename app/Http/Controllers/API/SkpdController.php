<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormSkpdRequest;
use App\Skpd;
use Illuminate\Support\Facades\Gate;

class SkpdController extends Controller
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
        $skpd = Skpd::latest()->paginate(10);

        return response()->json([
            'data' => $skpd
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSkpdRequest $request)
    {
        $skpd = Skpd::Create($request->all());
        
        return response()->json([
            'data' => $skpd,
            'message' => 'SKPD dengan kode: '.$request->kode_skpd.' ditambahkan'
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
    public function update(FormSkpdRequest $request, $id)
    {
        $skpd = Skpd::findOrFail($id);
        $skpd->update($request->all());

        return response()->json([
            'message'  => 'SKPD dengan kode:'.$skpd->kode_skpd.' telah diperbarui'
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
        // $skpd = Skpd::findOrFail($id);
        // $skpd->delete();

        // return response()->json([
        //     'message' => 'SKPD dengan kode: '.$skpd->kode_skpd.' telah dihapus'
        // ]);
    }

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $skpd = Skpd::where(function($query) use ($keywords) {
                $query->where('alias_skpd', 'LIKE', "%$keywords%")
                        ->orWhere('nama_skpd', 'LIKE', "%$keywords%")
                        ->orWhere('kode_skpd', 'LIKE', "%$keywords%");
            })->paginate(10);
        }

        return response()->json([
            'data' => $skpd
        ]);
    }
}
