<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = "user_progresses";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
    ];
}
