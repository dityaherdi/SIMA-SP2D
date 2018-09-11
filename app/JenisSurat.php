<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $fillable = [
        'kode_jenis_sp2d', 'nama_jenis_sp2d', 'keterangan', 'status'
    ];
}
