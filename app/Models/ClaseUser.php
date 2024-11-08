<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaseUser extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'clase_users';

    protected $fillable = [
        'user_id',
        'state_id',
    ];

    //La relacion hasMany indica que una clase puede tener muchas clases-usurios
    public function clase()
    {
        return $this->belongsTo(Clases::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
