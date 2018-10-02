<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Box;
use App\Http\Requests\FormBoxRequest;
use QRCode;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $box = Box::latest()->with([
            'rak' => function($query) {
                $query->select('id_rak', 'id_ruangan', 'kode_rak');
            },
            'rak.ruangan' => function($query) {
                $query->select('id_ruangan', 'id_gedung', 'kode_ruangan');
            },
            'rak.ruangan.gedung' => function($query) {
                $query->select('id_gedung', 'kode_gedung');
            }
        ])->get()->paginateCollection(3);

        return response()->json([
            'data' => $box
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBoxRequest $request)
    {
        $box = Box::create($request->all());

        return $this->generateBoxQr($box, $request);
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
    public function update(FormBoxRequest $request, $id)
    {
        $box = Box::findOrFail($id);
        $box->update($request->all());

        return $this->generateBoxQr($box, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $box = Box::findOrFail($id);
        $box->delete();
        @unlink(public_path('img/qr/box/'.$box->qr_box));

        return response()->json([
            'message' => 'Box dengan kode: '.$box->kode_box.' telah dihapus'
        ]);
    }

    public function generateBoxQr($box, $request)
    {
        $letak = Box::join('raks', 'raks.id_rak', '=', 'boxes.id_rak')
                    ->join('ruangans', 'ruangans.id_ruangan', '=', 'raks.id_ruangan')
                    ->join('gedungs', 'gedungs.id_gedung', '=', 'ruangans.id_gedung')
                    ->select('nama_gedung', 'kode_ruangan', 'kode_rak', 'kode_box')
                    ->where(['boxes.id_box' => $box->id_box, 'boxes.status' => 1])
                    ->get()->first();

        $currentBoxQr = $box->qr_box;
        $filename = str_slug($letak['kode_box']).'.png';
        $path = public_path('img/qr/box/'.$filename);
        QRCode::text(
            'Gedung : '.$letak['nama_gedung'].' / '.
            'Ruangan : '.$letak['kode_ruangan'].' / '.
            'Rak : '.$letak['kode_rak'].' / '.
            'Box : '.$letak['kode_box'])
                ->setSize(10)
                ->setMargin(1)
                ->setOutFile($path)
                ->png();
        $box->update(['qr_box' => $filename]);

        if ($request->isMethod('POST')) {
            return response()->json([
                'data' => $box,
                'message' => 'Box dengan kode: '.$request->kode_box.' ditambahkan'
            ]);
        }else if ($request->isMethod('PUT')) {
            @unlink(public_path('img/qr/box/'.$currentBoxQr));

            return response()->json([
                'data' => $box,
                'message' => 'Box dengan kode: '.$request->kode_box.' telah diperbarui'
            ]);
        }
    }
}
