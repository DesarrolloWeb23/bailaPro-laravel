<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
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
        'id',
        'capacidad',
        'duracion',
        'horario',
        'nombre',
        'user_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscripciones::class, 'clase_id');
    }

    public static function inscriptionsByStudent($studentId)
    {
        return self::whereHas('inscriptions', function($query) use ($studentId) {
            $query->where('user_id', $studentId);
        })->with('teacher')->get();
    }
}
