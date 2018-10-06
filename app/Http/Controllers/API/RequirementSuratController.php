<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Skpd;
use App\JenisSurat;

class RequirementSuratController extends Controller
{
    public function getSkpd()
    {
        $skpd = Skpd::select('id_skpd', 'kode_skpd', 'nama_skpd')
                    ->where('status', 1)
                    ->orderBy('nama_skpd', 'ASC')
                    ->get();
        
        return response()->json([
            'data' => $skpd
        ]);
    }

    public function getJenis()
    {
        $jenis = JenisSurat::select('id_jenis_sp2d','kode_jenis_sp2d', 'nama_jenis_sp2d')
                            ->where('status', 1)
                            ->orderBy('id_jenis_sp2d', 'ASC')
                            ->get();

        return response()->json([
            'data' => $jenis
        ]);
    }
}
