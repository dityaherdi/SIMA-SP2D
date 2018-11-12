<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $primaryKey = 'id_box';

    protected $fillable = [
        'id_rak', 'kode_box', 'kapasitas', 'jml_arsip', 'qr_box', 'status_retensi_box'. 'keterangan', 'status'
    ];

    public function rak()
    {
        return $this->belongsTo('App\Rak', 'id_rak');
    }

    public function arsip()
    {
        return $this->hasMany('App\Arsip', 'id_arsip');
    }

}
