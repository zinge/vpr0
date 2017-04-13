<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipType extends Model
{
  //
  protected $fillable = ['name'];

  public function equips()
  {
    return $this->hasMany('App\Equip');
  }
}
