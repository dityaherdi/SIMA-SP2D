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
        $suratToday = Surat::whereDate('created_at', Carbon::today())->where(['arsip' => 0, 'status' => 1 ])->count();

        return response()->json([
            'data' => $suratToday
        ]);
    }

    public function arsipToday()
    {
        $arsipToday = Arsip::whereDate('created_at', Carbon::today())->where(['status_retensi' => 0, 'status' => 1 ])->count();
        
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
        $arsRetensi = Arsip::whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->where('status_retensi', 0)->count();
        
        return response()->json([
            'data' => $arsRetensi
        ]);
    }

    public function latestSurat()
    {
        $latestSur = Surat::orderBy('tgl_terbit', 'DESC')->with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0])->limit(5)->get();

        return response()->json([
            'data' => $latestSur
        ]);
    }

    public function latestArsip()
    {
        $latestArs = Arsip::orderBy('tgl_diarsipkan', 'DESC')->with([
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
        $latestRet = Arsip::where('status_retensi', 1)->with('surat:id_sp2d,nomor_surat')->orderBy('updated_at', 'DESC')->limit(5)->get();

        return response()->json([
            'data' => $latestRet
        ]);
    }

    public function detailSurat()
    {
        $surat = Surat::latest()->with([
            'skpd:id_skpd,kode_skpd,nama_skpd',
            'jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d'
        ])->where(['arsip' => 0, 'status' => 1])->get()->paginateCollection(15);

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
        ])->where('status', 1)->get()->paginateCollection(15);

        return response()->json([
            'data' => $arsip
        ]);
    }

    public function detailRetensi()
    {
        $retensiArs = Arsip::whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
        ])->where('status_retensi', 0)->get()->paginateCollection(15);

        return response()->json([
            'data' => $retensiArs
        ]);
    }
}