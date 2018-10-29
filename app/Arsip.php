<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $primaryKey = 'id_arsip';

    protected $fillable = [
        'id_sp2d', 'id_box', 'tgl_diarsipkan', 'tgl_perkiraan_retensi', 'qr_arsip', 'keterangan', 'status'
    ];

    public function surat() {
        return $this->belongsTo('App\Surat', 'id_sp2d');
    }

    public function box() {
        return $this->belongsTo('App\Box', 'id_box');
    }
}
