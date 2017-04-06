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
    $this->belongsTo('App\Manufacturer');
  }

  public function equip_model()
  {
    $this->belongsTo('App\EquipModel');
  }

  public function equip_type()
  {
    $this->belongsTo('App\EquipType');
  }

  public function employee()
  {
    $this->belongsTo('App\Employee');
  }

  public function workplaces()
  {
    return $this->morphToMany('App\Workplace', 'workplaceable');
  }
}
