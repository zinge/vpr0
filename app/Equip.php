<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equip extends Model
{
  //
  protected $fillable = [
    'name', 'initial_date', 'initial_cost', 'serial_number', 'sap_number',
    'manufacturer_number', 'active'
  ];

  public function manufacturer()
  {
    return $this->belongsTo('App\Manufacturer');
  }

  public function equip_model()
  {
    return $this->belongsTo('App\EquipModel');
  }

  public function equip_type()
  {
    return $this->belongsTo('App\EquipType');
  }

  public function employee()
  {
    return $this->belongsTo('App\Employee');
  }

  public function workplaces()
  {
    return $this->morphToMany('App\Workplace', 'workplaceable');
  }
}
