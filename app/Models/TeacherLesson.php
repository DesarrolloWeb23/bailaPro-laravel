<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherLesson extends Model
{
    protected $table = 'teacher_lessons';

    protected $fillable = [
        'lesson_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    //La relacion hasMany indica que una clase puede tener muchas clases-usurios
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
