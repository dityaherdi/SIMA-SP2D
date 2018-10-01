<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $primaryKey = 'id_box';

    protected $fillable = [
        'id_rak', 'kode_box', 'kapasitas', 'qr_box', 'keterangan', 'status'
    ];

    public function rak()
    {
        return $this->belongsTo('App\Rak', 'id_rak');
    }

}
