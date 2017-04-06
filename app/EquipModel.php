<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipModel extends Model
{
  //
  protected $fillable = ['name'];

  public function equips()
  {
    $this->hasMany('App\Equip');
  }
}
