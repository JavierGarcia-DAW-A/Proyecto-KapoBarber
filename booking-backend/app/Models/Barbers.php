<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barbers extends Model
{
    protected $fillable = ['wp_id', 'name', 'slug', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
