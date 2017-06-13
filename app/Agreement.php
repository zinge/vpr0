<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    //
    protected $fillable = ['name', 'initial_date', 'end_date'];

    public function agreement_strings()
    {
      return $this->hasMany('App\AgreementString');
    }

    public function contractor()
    {
      return $this->belongsTo('App\Contractor');
    }
}
