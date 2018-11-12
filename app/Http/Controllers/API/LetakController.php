<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gedung;
use App\Ruangan;
use App\Rak;
use App\Box;
use App\Arsip;

class LetakController extends Controller
{
    public function letakGedung()
    {
        $gedung = Gedung::select('id_gedung', 'nama_gedung')
                        ->where('status',1)
                        ->orderBy('nama_gedung', 'ASC')
                        ->get();

        return response()->json([
            'data' => $gedung
        ]);
    }

    public function letakRuangan($id)
    {
        $ruangan = Ruangan::select('id_ruangan', 'kode_ruangan')
                        ->where(['id_gedung' => $id, 'status' => 1])
                        ->orderBy('kode_ruangan', 'ASC')
                        ->get();

        return response()->json([
            'data' => $ruangan
        ]);
    }

    public function letakRak($id)
    {
        $rak = Rak::select('id_rak', 'kode_rak')
                    ->where(['id_ruangan' => $id, 'status' => 1])
                    ->orderBy('kode_rak', 'ASC')
                    ->get();

        return response()->json([
            'data' => $rak
        ]);
    }

    public function letakBox($id)
    {
        $data = Box::select('id_box', 'kode_box', 'kapasitas', 'jml_arsip')
                    ->where(['id_rak' => $id, 'status' => 1, 'status_retensi_box' => 0])
                    ->orderBy('jml_arsip', 'ASC')
                    ->orderBy('kode_box', 'ASC')
                    ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
