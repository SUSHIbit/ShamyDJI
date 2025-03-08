<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;

    public function details()
    {
        return $this->hasOne(CameraDetail::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
