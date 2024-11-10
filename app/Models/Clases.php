<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ClaseUser;
use App\Models\Inscripciones;

class Clases extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
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
