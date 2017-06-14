<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Akt extends Model
{
    //
    protected $fillable = ['name', 'billing_date', 'billing_month'];

    public function agreement()
    {
      return $this->belongsTo('App\Agreement');
    }

    public function aktstrings()
    {
      return $this->hasMany('App\Aktstring');
    }
}
