<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = ['name', 'cost'];

    public function finposition()
    {
      return $this->belongsTo('App\Finposition');
    }

    public function agreement_strings()
    {
      return $this->hasMany('App\AgreementString');
    }

    public function aktstrings()
    {
      return $this->hasMany('App\Aktstring');
    }
}
