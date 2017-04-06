<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilePhone extends Model
{
  //
  protected $fillable = ['number'];
  
  public function mobile_type()
  {
    $this->belongsTo('App\MobileType');
  }

  public function mobile_limit()
  {
    $this->belongsTo('App\MobileLimit');
  }

  public function employee()
  {
    $this->belongsTo('App\Employee');
  }
}
