<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pickup_location',
        'pickup_time',
        'return_time',
        'delivery_available',
        'terms_conditions',
    ];

    /**
     * Get the camera that owns the details.
     */
    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}