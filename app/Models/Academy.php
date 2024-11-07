<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    //Desactivar el timestamp
    public $timestamps = false;

    protected $table = 'academies';
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'rating',
    ];

    //La relacion hasMany indica que una academia puede tener muchos usuarios-academia
    public function academyUser()
    {
        return $this->hasMany(AcademyUser::class);
    }
}
