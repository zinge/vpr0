<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipType extends Model
{
  //
  protected $fillable = ['name'];

  public function equips()
  {
    $this->hasMany('App\Equip');
  }
}
