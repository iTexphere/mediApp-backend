<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Booking;

class Patient extends Model
{
	protected $fillable = [
	    'first_name', 'last_name', 'nic', 'email', 'mobile_number', 'city', 'district', 'user_id'
	];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function bookings(){
		return $this->hasMany(Booking::class);
	}

}
