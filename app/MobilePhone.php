<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilePhone extends Model
{
  //
  protected $fillable = ['number'];

  public function mobile_type()
  {
    return $this->belongsTo('App\MobileType');
  }

  public function mobile_limit()
  {
    return $this->belongsTo('App\MobileLimit');
  }

  public function employee()
  {
    return $this->belongsTo('App\Employee');
  }
}
