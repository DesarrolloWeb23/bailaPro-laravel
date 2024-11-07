<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{

    protected $table = 'pays';
    protected $fillable = [
        'name',
        'description',
        'amount',
        'user_id',
        'state_id',

    ];

    //La relacion BelongsTo indica que un pago pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
