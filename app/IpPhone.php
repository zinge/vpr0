<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpPhone extends Model
{
  //
  protected $fillable = ['macaddr'];

  public function phone()
  {
    return $this->belongsTo('App\Phone');
  }
}
