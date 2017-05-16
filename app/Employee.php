<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  //
  protected $fillable = ['firstname', 'patronymic', 'surname', 'department_id', 'address_id', 'active'];

  public function department()
  {
    return $this->belongsTo('App\Department');
  }

  public function address()
  {
    return $this->belongsTo('App\Address');
  }

  public function equips()
  {
    return $this->hasMany('App\Equip');
  }

  public function phones()
  {
    return $this->belongsToMany('App\Phone', 'phone_owners');
  }

  public function mobile_limits()
  {
    return $this->belongsToMany('App\MobileLimit', 'mobile_phones');
  }

  public function mobile_types()
  {
    return $this->belongsToMany('App\MobileType', 'mobile_phones');
  }

  public function workplaces()
  {
    return $this->morphToMany('App\Workplace', 'workplaceable');
  }
}
