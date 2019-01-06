<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class ZoneUser extends Model
{
   
    protected $table = 'zone_user';
    public function user() {
        return $this->belongsTo('App\Model\User\User');
    }
    public function zone() {
        return $this->belongsTo('App\Model\Setup\Zone');
    }
   
}
