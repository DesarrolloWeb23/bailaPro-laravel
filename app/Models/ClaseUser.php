<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaseUser extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'clase_users';

    protected $fillable = [
        'clase_id',
        'user_id',
        'state_id',
        'inscription_date'
    ];

    //La relacion hasMany indica que una clase puede tener muchas clases-usurios
    public function clase()
    {
        return $this->belongsTo(Clases::class, 'clase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
