<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiantes;

class Pagos extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'concepto',
        'fecha_pago',
        'monto',
        'estudiante_id'
    ];

    //relacion con los estudiantes
    public function student()
    {
        return $this->belongsTo(Estudiantes::class, 'estudiante_id');
    }
}
