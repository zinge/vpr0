<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
  //
  protected $fillable = ['name', 'active'];

  public function employees()
  {
    return $this->morphedByMany('App\Employee', 'workplaceable');
  }

  public function phones()
  {
    return $this->morphedByMany('App\Phone', 'workplaceable');
  }

  public function equips()
  {
    return $this->morphedByMany('App\Equip', 'workplaceable');
  }
}
