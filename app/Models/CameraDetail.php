<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraDetail extends Model
{
    use HasFactory;

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
