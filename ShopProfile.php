<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopProfile extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id';
    public $table = 'shop_profiles';

    public function user(){
        return $this->belongsTo('App\User');
    }
}