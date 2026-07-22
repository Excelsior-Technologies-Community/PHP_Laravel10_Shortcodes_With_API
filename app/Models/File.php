<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'url',
        'size',
        'mime_type'
    ];
}
