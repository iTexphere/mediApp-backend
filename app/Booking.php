<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Medical;

class Booking extends Model
{
    protected $fillable = [
        'patient_id', 'medical_id', 'booking_no'
    ];

   	public function patient(){
   		return $this->belongsTo(Patient::class);
   	}

   	public function medical(){
   		return $this->belongsTo(Medical::class);
   	}
}
