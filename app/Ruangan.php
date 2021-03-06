<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'id_gedung', 'kode_ruangan', 'keterangan', 'status'
    ];

    public function gedung()
    {
        return $this->belongsTo('App\Gedung', 'id_gedung');
    }

    public function rak()
    {
        return $this->hasMany('App\Rak', 'id_rak');
    }
}
