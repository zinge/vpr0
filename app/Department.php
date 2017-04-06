<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  //
  protected $fillable = ['name', 'active'];

  public function address()
  {
    $this->belongsTo('App\Address');
  }

  public function employees()
  {
    $this->hasMany('App\Employee');
  }
}
