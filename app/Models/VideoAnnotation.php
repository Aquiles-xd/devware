<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAnnotation extends Model
{
    use HasFactory;

    public $table = 'videos_annotation';
}
