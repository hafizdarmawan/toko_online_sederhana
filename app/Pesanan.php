<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    //


    // one to many dengan user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function pesanan_detail(){
        return $this->hasMany(PesananDetail::class,'pesanan_id','id');
    }

}
