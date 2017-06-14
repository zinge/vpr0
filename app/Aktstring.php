<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktstring extends Model
{
    //
    protected $fillable = ['physical', 'summ_cost'];

    public function service()
    {
      return $this->belongsTo('App\Service');
    }

    public function akt()
    {
      return $this->belongsTo('App\Akt');
    }
}
