<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $primaryKey = 'id_rak';

    protected $fillable = [
        'id_ruangan', 'kode_rak', 'qr_rak', 'keterangan', 'status'
    ];

    public function ruangan()
    {
        return $this->belongsTo('App\Ruangan', 'id_ruangan');
    }

    public function boxes()
    {
        return $this->hasMany('App\Box');
    }
}
