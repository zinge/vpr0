<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadFiles extends Model
{
    //
    protected $fillable = ['file_name', 'mime_type', 'original_filename'];
}
