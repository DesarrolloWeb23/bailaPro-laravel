<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //sin timestamps
    public $timestamps = false;

    protected $table = 'services';
    protected $fillable = ['academy_id', 'name', 'description', 'price'];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}
