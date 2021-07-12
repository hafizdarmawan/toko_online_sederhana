<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [

    ];

    protected $hidden = [

    ];

    public function pesanan_detail(){
        return $this->hasMany(PesananDetail::class,'barang_id','id');
    }


}
