<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileType extends Model
{
  //
  protected $fillable = ['name'];

  public function mobile_phones()
  {
    $this->hasMany('App\MobilePhone');
  }

  public function mobile_limits()
  {
    $this->belongsToMany('App\MobileLimit', 'mobile_phones');
  }

  public function employees()
  {
    $this->belongsToMany('App\Employee', 'mobile_phones');
  }
}
