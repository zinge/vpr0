<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  //
  protected $fillable = ['city', 'street', 'house', 'active'];

  public function departments()
  {
    return $this->hasMany('App\Department');
  }

  public function employees()
  {
    return $this->hasManyThrough('App\Employee', 'App\Department');
  }
}
