<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileLimit extends Model
{
  //

  protected $fillable = ['limit_cost'];

  public function mobile_phones()
  {
    return $this->hasMany('App\MobilePhone');
  }

  public function mobile_types()
  {
    return $this->belongsToMany('App\MobileType', 'mobile_phones');
  }

  public function employees()
  {
    return $this->belongsToMany('App\Employee', 'mobile_phones');
  }
}
