<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fu extends Model
{
    //
    protected $fillable = ['file_name', 'mime_type', 'original_filename'];
}
