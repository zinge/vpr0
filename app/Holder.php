<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holder extends Model
{
    protected $fillable = ['name'];

    public function equips()
    {
      return $this->hasMany('App\Equip');
    }
}
