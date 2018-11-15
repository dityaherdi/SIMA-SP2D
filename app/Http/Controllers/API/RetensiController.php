<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Retensi;
use App\Arsip;
use App\Surat;
use App\Box;
use Carbon\Carbon;

class RetensiController extends Controller
{
    public function index()
    {
        $arsip = Arsip::whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->where('status_retensi', 0)->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian'
        ])->limit(50)->get();

        return response()->json([
            'data' => $arsip,
            'total' => $arsip->count()
        ]);
    }

    public function bulkRetensi()
    {
        $arsip = Arsip::whereYear('tgl_perkiraan_retensi', Carbon::now()->year)->where('status_retensi', 0)->with([
            'surat:id_sp2d,id_skpd,id_jenis_sp2d,nomor_surat,tgl_terbit,uraian',
            'surat.skpd:id_skpd,kode_skpd,nama_skpd',
            'surat.jenis:id_jenis_sp2d,kode_jenis_sp2d,nama_jenis_sp2d',
            'box:id_box,id_rak,kode_box',
            'box.rak:id_rak,id_ruangan,kode_rak',
            'box.rak.ruangan:id_ruangan,id_gedung,kode_ruangan',
            'box.rak.ruangan.gedung:id_gedung,nama_gedung'
        ]);

        // return $arsip->get()->count();

        if ($arsip->get()->count()!=0) {
            $arsip->update(['status_retensi' => 1]);
    
            // update jumlah arsip pada setiap box yang di retensi dan ubah status retensi box
            $idb = $arsip->pluck('id_box')->unique()->toArray();
            foreach($idb as $id) {
                if (!empty($id)) {
                    $box = Box::where('id_box', $id)->first();
                    if ($box->jml_arsip > 0) {
                        Box::where('id_box', $id)->decrement('jml_arsip', Arsip::where([['id_box', $id], ['status_retensi', 1]])->count(['status_retensi']));
                        Box::where('id_box', $id)->update(['status_retensi_box' => 1]);
                    }
                }
            }
    
            return response()->json([
                'messages' => 'Retensi Arsip SP2D Tahun ini sudah dilakukan'
            ]);
        }else {
            return 'tidak ada data';
        }
    }
}
