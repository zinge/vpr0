<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  //
  protected $fillable = ['firstname', 'patronymic', 'surname', 'active'];

  public function department()
  {
    $this->belongsTo('App\Department');
  }

  public function equips()
  {
    $this->hasMany('App\Equip');
  }

  public function phones()
  {
    $this->belongsToMany('App\Phone', 'phone_owners');
  }

  public function mobile_limits()
  {
    $this->belongsToMany('App\MobileLimit', 'mobile_phones');
  }

  public function mobile_types()
  {
    $this->belongsToMany('App\MobileType', 'mobile_phones');
  }
  
  public function workplaces()
  {
    return $this->morphToMany('App\Workplace', 'workplaceable');
  }
}
