<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  //
  protected $fillable = ['name', 'active'];

  public function address()
  {
    return $this->belongsTo('App\Address');
  }

  public function employees()
  {
    return $this->hasMany('App\Employee');
  }
}
