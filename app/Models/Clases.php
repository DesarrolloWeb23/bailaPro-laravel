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

    protected $table = 'clases';

    protected $fillable = [
        'name',
        'description',
        'duration',
        'shedule',
        'capacity',
        'start_date',
        'end_date',
        // 'quota',// Pendiente
        'state_id',
    ];

    //La relacion hasMany indica que una clase puede tener muchas clases-usurios
    public function claseUser()
    {
        return $this->hasMany(ClaseUser::class);
    }
}
