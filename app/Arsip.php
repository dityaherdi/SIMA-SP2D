<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arsip extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_arsip';

    protected $fillable = [
        'id_sp2d', 'id_box', 'tgl_diarsipkan', 'tgl_perkiraan_retensi', 'qr_arsip', 'keterangan', 'status'
    ];

    protected $dates = ['deleted_at'];

    public function surat() {
        return $this->belongsTo('App\Surat', 'id_sp2d');
    }

    public function box() {
        return $this->belongsTo('App\Box', 'id_box');
    }
}
