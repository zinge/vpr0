<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $fillable = ['number', 'active'];

    public function phone_type()
    {
      return $this->hasOne('App\PhoneType');
    }
}
