<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $primaryKey = 'id_sp2d';

    protected $fillable = [
        'id_skpd', 'id_jenis_sp2d', 'nomor_surat', 'tgl_terbit', 'uraian', 'keterangan', 'status', 'arsip'
    ];

    public function skpd()
    {
        return $this->belongsTo('App\Skpd', 'id_skpd');
    }

    public function jenis()
    {
        return $this->belongsTo('App\JenisSurat', 'id_jenis_sp2d');
    }
}
