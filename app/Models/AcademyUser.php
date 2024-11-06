<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyUser extends Model
{
    protected $table = 'academy_users';

    protected $fillable = [
        'academy_id',
        'user_id',
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
