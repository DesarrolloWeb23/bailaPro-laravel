<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherLesson extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo
    
    protected $table = 'teacher_lessons';

    protected $fillable = [
        'lesson_id',
        'user_id'
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
