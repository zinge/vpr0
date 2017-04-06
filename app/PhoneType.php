<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneType extends Model
{
    //
    protected $fillable = ['name'];

    public function phones()
    {
      return $this->hasMany('App\Phone');
    }
}
