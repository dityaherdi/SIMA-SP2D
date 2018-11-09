<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gedung;
use App\Ruangan;
use App\Rak;
use App\Box;
use App\Surat;
use App\Arsip;
use App\Retensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function suratToday()
    {
        $suratToday = Surat::whereDate('created_at', Carbon::today())->count();

        return response()->json([
            'data' => $suratToday
        ]);
    }

    public function arsipToday()
    {
        $arsipToday = Arsip::whereDate('created_at', Carbon::today())->count();
        
        return response()->json([
            'data' => $arsipToday
        ]);
    }

    public function totalStorage()
    {
        $countGed = Gedung::where('status',1)->count();
        $countRua = Ruangan::where('status',1)->count();
        $countRak = Rak::where('status',1)->count();
        $countBox = Box::where('status',1)->count();

        return response()->json([
            'data' => [
                'countedGed' => $countGed,
                'countedRua' => $countRua,
                'countedRak' => $countRak,
                'countedBox' => $countBox
            ]
        ]);
    }

    public function retensiThisYear()
    {
        $arsRetensi = Arsip::whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->count();
        
        return response()->json([
            'data' => $arsRetensi
        ]);
    }

    public function latestSurat()
    {
        $latestSur = Surat::latest()->with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0])->limit(5)->get();

        return response()->json([
            'data' => $latestSur
        ]);
    }

    public function latestArsip()
    {
        $latestArs = Arsip::latest()->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
            'surat.skpd:id_skpd,kode_skpd,nama_skpd',
            'surat.jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d',
            'box:id_box,id_rak,kode_box',
            'box.rak:id_rak,id_ruangan,kode_rak',
            'box.rak.ruangan:id_ruangan,id_gedung,kode_ruangan',
            'box.rak.ruangan.gedung:id_gedung,nama_gedung'
        ])->limit(5)->get();

        return response()->json([
            'data' => $latestArs
        ]);
    }

    public function latestRetensi()
    {
        $latestRet = Retensi::latest()->limit(5)->get();

        return response()->json([
            'data' => $latestRet
        ]);
    }

    public function detailSurat()
    {
        $surat = Surat::latest()->with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0])->get()->paginateCollection(20);

        return response()->json([
            'data' => $surat
        ]);
    }

    public function detailArsip()
    {
        $arsip = Arsip::latest()->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
            'surat.skpd:id_skpd,kode_skpd,nama_skpd',
            'surat.jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d',
            'box:id_box,id_rak,kode_box',
            'box.rak:id_rak,id_ruangan,kode_rak',
            'box.rak.ruangan:id_ruangan,id_gedung,kode_ruangan',
            'box.rak.ruangan.gedung:id_gedung,nama_gedung'
        ])->get()->paginateCollection(10);

        return response()->json([
            'data' => $arsip
        ]);
    }

    public function detailRetensi()
    {
        $retensiArs = Arsip::with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
        ])->whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->get();

        return response()->json([
            'data' => $retensiArs
        ]);
    }
}