<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Patient;
Use App\Booking;
use Carbon\Carbon;

use App\Http\Resources\MedicalBooking;

class BookingController extends Controller
{
    //Create New Booking By Medical Center 
    public function booking(){


    	$patient = Patient::where('medi_track', 'yes')->first();
        $medical = auth()->user()->medical;

    	if ($medical && $patient) {

    		if ($medical->issuing == 'off') {
    			return response()->json([
					'status' => 'faild',
					'message'=> 'Booking is currently off. Please try again later',
				], 400);
    		}


    	 $booking = Booking::whereDate('created_at', Carbon::today())->where('medical_id', $medical->id)->latest()->first();
    		(!$booking)? $booking_number = 1 : $booking_number = $booking->booking_no + 1;

			DB::beginTransaction();
    			$newBooking = Booking::create([
    				'patient_id' => $patient->id,
    				'medical_id' => $medical->id,
    				'booking_no' => $booking_number,
    			]);
    			$updateMedical = $medical->update(['current_issues_no' => $newBooking->booking_no ]);

    			if ($newBooking && $updateMedical) {
    		DB::commit();

					return response()->json([
		    			'status' => 'success',
		    			'data'	 => [
		    				'booking_no' => $newBooking->booking_no
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

    //Get Booking Data
    public function ourbooking(Request $request){

        $this->validate($request, ['booking_date' => 'date']);

        
        if ($request->booking_no && $request->booking_date) {

            $bookings = Booking::whereDate('created_at', $request->booking_date)->where([
                ['medical_id', '=', auth()->user()->medical->id],
                ['booking_no', '=', $request->booking_no]
            ])->latest()->get();

        }elseif (!isset($request->booking_no) && $request->booking_date) {

            $bookings = Booking::whereDate('created_at', $request->booking_date)->where('medical_id', auth()->user()->medical->id)->latest()->get();

        }elseif (!isset($request->booking_date) && $request->booking_no) {

            $bookings = Booking::where([
                ['medical_id', '=', auth()->user()->medical->id],
                ['booking_no', '=', $request->booking_no]
            ])->latest()->get();
        }else{

            $bookings = Booking::where('medical_id', auth()->user()->medical->id)->latest()->get();
        }

  
        if ($bookings->count() > 0) {

            return response()->json([
                'status' => 'success',
                'data'=> MedicalBooking::collection($bookings)
            ], 200);


        }else{
            return response()->json([
                'status' => 'faild',
                'message'=> 'No booking data found',
            ], 400);
        }
    }
}
