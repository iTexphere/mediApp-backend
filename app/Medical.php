<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Medical extends Model
{
    protected $fillable = [
        'reg_no', 'center_name', 'dr_name', 'specialist_in', 'start_time', 'end_time', 'open_days', 'city', 'district', 'dr_notes', 'image', 'latitude', 'longitude', 'issuing_no', 'session_no', 'current_issues_no', 'user_id'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
