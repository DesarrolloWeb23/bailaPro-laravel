<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripciones extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'fecha_inscripcion',
        'clase_id',
        'estudiante_id'
    ];

    //relacion con los estudiantes
    public function student()
    {
        return $this->belongsTo(Estudiantes::class, 'estudiante_id');
    }

    //relacion con las clases
    public function lesson()
    {
        return $this->belongsTo(Clases::class, 'clase_id');
    }
}
