<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgreementString extends Model
{
    //
    protected $fillable = ['physical', 'summ_cost'];

    public function service()
    {
      return $this->belongsTo('App\Service');
    }

    public function department()
    {
      return $this->belongsTo('App\Department');
    }

    public function agreement()
    {
      return $this->belongsTo('App\Agreement');
    }
}
