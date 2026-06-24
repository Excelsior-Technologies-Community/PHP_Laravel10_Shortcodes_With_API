<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortcodeHistory extends Model
{
    protected $fillable = [
        'original_content',
        'parsed_content'
    ];
}