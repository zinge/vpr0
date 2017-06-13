<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    //
    protected $fillable = ['name'];

    public function agreements()
    {
      return $this->hasMany('App\Agreement');
    }
}
