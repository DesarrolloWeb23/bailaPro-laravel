<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'user_id'
    ];

    //relacion con los estudiantes
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //relacion con las clases
    public function lesson()
    {
        return $this->belongsTo(Clases::class, 'clase_id');
    }
}
