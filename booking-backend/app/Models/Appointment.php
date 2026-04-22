<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'barber_id', 'date', 'time', 'phone', 'service', 'price', 'is_executed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barbers::class, 'barber_id');
    }
}
