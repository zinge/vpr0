<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileType extends Model
{
  //
  protected $fillable = ['name'];

  public function mobile_phones()
  {
    return $this->hasMany('App\MobilePhone');
  }

  public function mobile_limits()
  {
    return $this->belongsToMany('App\MobileLimit', 'mobile_phones');
  }

  public function employees()
  {
    return $this->belongsToMany('App\Employee', 'mobile_phones');
  }
}
