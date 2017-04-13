<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
  //
  protected $fillable = ['number', 'active'];

  public function phone_type()
  {
    return $this->belongsTo('App\PhoneType');
  }

  public function ip_phone()
  {
    return $this->hasOne('App\IpPhone');
  }

  public function employees()
  {
    return $this->belongsToMany('App\Employee', 'phone_owners');
  }

  public function workplaces()
  {
    return $this->morphToMany('App\Workplace', 'workplaceable');
  }
}
