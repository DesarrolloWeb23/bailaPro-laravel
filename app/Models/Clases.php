<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profesores;

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
        'profesor_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Profesores::class, 'profesor_id');
    }
}
