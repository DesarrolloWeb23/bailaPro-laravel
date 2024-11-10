<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ClaseUser;
use App\Models\Inscripciones;
use App\Models\Academy;
use App\Models\TeacherLesson;

class Lesson extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'lessons';

    protected $fillable = [
        'name',
        'description',
        'duration',
        'schedule',
        'capacity',
        'start_date',
        'end_date',
        // 'quota',// Pendiente
        'state_id',
        'academy_id'
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_lessons', 'lesson_id', 'user_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(ClaseUser::class, 'clase_id');
    }

    public static function inscriptionsByStudent($studentId)
    {
        return self::whereHas('inscriptions', function($query) use ($studentId) {
            $query->where('user_id', $studentId);
        })->get();
    }
}
