<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'client';
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'agree_terms' => 'required|accepted',
        ];
    }
    
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Get the camera from the route
            $camera = $this->route('camera');
            
            if (!$camera || !$camera->is_active) {
                $validator->errors()->add('camera', 'This camera is not available for booking.');
                return;
            }
            
            // Get dates from the request
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);
            
            // Check for conflicting bookings
            $conflictingBookings = Booking::where('camera_id', $camera->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($query) use ($startDate, $endDate) {
                            $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                        });
                })
                ->exists();
                
            if ($conflictingBookings) {
                $validator->errors()->add('date_conflict', 'One or more of the selected dates are already booked.');
            }
        });
    }
}
