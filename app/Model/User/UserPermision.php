<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class UserPermision extends Model
{
   
    protected $table = 'user_permision';
    public function user() {
        return $this->belongsTo('App\Model\User\User');
    }
    public function permision() {
        return $this->belongsTo('App\Model\User\Permision');
    }
   
}
