<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $primaryKey = 'id_gedung';

    protected $fillable = [
        'kode_gedung', 'nama_gedung', 'alamat', 'keterangan', 'status'
    ];

    public function ruangans()
    {
        return $this->hasMany('App\Ruangan', 'id_gedung');
    }
}
