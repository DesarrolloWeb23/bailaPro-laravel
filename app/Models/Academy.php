<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    //
    protected $table = 'academys';

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'rating'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
