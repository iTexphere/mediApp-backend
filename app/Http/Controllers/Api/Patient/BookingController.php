<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Medical;
Use App\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function booking($medicalid){


    	$medical = Medical::find($medicalid);

    	if ($medical) {

    		if ($medical->issuing == 'off') {
    			return response()->json([
					'status' => 'faild',
					'message'=> 'Booking is currently off. Please try again later',
				], 400);
    		}

            if (Booking::whereDate('created_at', Carbon::today())->where('medical_id', $medicalid)->where('patient_id', auth()->user()->patient->id)->get()->count() > 0) {
                return response()->json([
                    'status' => 'faild',
                    'message'=> 'You already have a booking here, Please try again tomorrow',
                ], 400);
            }

    	 $booking = Booking::whereDate('created_at', Carbon::today())->where('medical_id', $medicalid)->latest()->first();
    		(!$booking)? $booking_number = 1 : $booking_number = $booking->booking_no + 1;

			DB::beginTransaction();
    			$newBooking = Booking::create([
    				'patient_id' => auth()->user()->patient->id,
    				'medical_id' => $medicalid,
    				'booking_no' => $booking_number,
    			]);
    			$updateMedical = $medical->update(['current_issues_no' => $newBooking->booking_no ]);

    			if ($newBooking && $updateMedical) {
    		DB::commit();

					return response()->json([
		    			'status' => 'success',
		    			'data'	 => [
		    				'booking_no' => $newBooking->booking_no,
		    				'medical'	 => $newBooking->medical
		    			]
		    		], 200);
    			
    			}else{
    		DB::rollBack();

					return response()->json([
						'status' => 'faild'
					], 400);
    			}

    	}else{
    		return response()->json([
    			'status' => 'faild'
    		], 400);
    	}

    }
}
