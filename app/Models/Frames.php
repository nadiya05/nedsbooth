<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frames extends Model
{
    protected $fillable = ['name', 'image_path', 'width', 'height', 'shot_count', 'slot_width', 'slot_height', 'slot_gap'];
}

