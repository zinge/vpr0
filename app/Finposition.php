<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finposition extends Model
{
    //
    protected $fillable = ['name', 'code'];

    public function services()
    {
      return $this->hasMany('App\Services');
    }
}
