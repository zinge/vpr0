<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileLimit extends Model
{
  //
  public function mobile_phones()
  {
    $this->hasMany('App\MobilePhone');
  }

  public function mobile_types()
  {
    $this->belongsToMany('App\MobileType', 'mobile_phones');
  }

  public function employees()
  {
    $this->belongsToMany('App\Employee', 'mobile_phones');
  }
}
