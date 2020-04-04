<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    //
    public $timestamps = false;

    public $primaryKey = 'id';

    public $table = 'customer_profiles';

    public function user(){
        return $this->belongsTo('App\User');
    }
}