<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Skpd extends Model
{
    protected $fillable = [
        'kode_skpd', 'nama_skpd', 'alias_skpd', 'keterangan', 'status'
    ];
    
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
}
