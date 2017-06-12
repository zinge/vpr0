<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneOwner extends Model
{
  public function employee()
  {
    return $this->belongsTo('App\Employee');
  }

  public function phone()
  {
    return $this->belongsTo('App\Phone');
  }
}
