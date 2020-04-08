<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\User;
use App\Medical;

use App\Http\Resources\Medical as MedicalResource;


class UserController extends Controller
{
  public function signup(Request $request){  

    //Validate Request
    $this->validate($request, [
      //Medical
      'reg_no'       => 'required',
      'center_name'  => 'required',
      'dr_name'      => 'required',
      'specialist_in' => 'required',
      'start_time'    => 'required',
      'end_time'  => 'required',
      'open_days' => 'required',
      'city'      => 'required',
      'district'  => 'required',
      'dr_notes'  => 'required',

      //Use
      'user_name' => 'required|unique:users,user_name',
      'role'      => ['required', Rule::in(['medical'])],
      'password'  => 'required',
    ]);

  DB::beginTransaction();

   	//Create New User
   	$newUser = User::create([
   		'user_name'	=> $request->user_name,
      'role'      => $request->role,
   		'password'	=> bcrypt($request->password),
   	]);


    if ($newUser) {

      //Create Medical 
      $newMedical = Medical::create([

        'user_id'      => $newUser->id,
        'reg_no'       => $request->reg_no,
        'center_name'  => $request->center_name,
        'dr_name'      => $request->dr_name,
        'specialist_in' => $request->specialist_in,
        'start_time'    => $request->start_time,
        'end_time'  => $request->end_time,
        'open_days' => $request->open_days,
        'city'      => $request->city,
        'district'  => $request->district,
        'dr_notes'  => $request->dr_notes,

      ]);

    }

   	//API Response
   	if ($newUser && $newMedical) {
  DB::commit();
   		return response()->json([
	            'status'=> 'success',
	            'data'	=> [
                  'user'         => $newUser,
                  'medical_info' => $newMedical
              ]
	        ], 200);
   	}else{
  DB::rollBack();
			  return response()->json([
	        'status'=> 'failed',
	      ], 400);
   	}



  } // End of 'signup'


  public function signin(Request $request){
   	//Validate Request
   	$valid_credential = $this->validate($request, [
   		'user_name'	=> 'required',
   		'password'	=> 'required',
   	]);


   	if (Auth::attempt($valid_credential)) {

	    //Generate Access Token
	    $accessToken = auth()->user()->createToken('mediApp', ['medical-center'])->accessToken;

      return response()->json([
        'status'        => 'success',
        'user_info'     => new MedicalResource(auth()->user()),
        'access_token'  => $accessToken
      ], 200);
   	             
	  }else{
      return response()->json([
        'status'    => 'failed'
      ], 400);
	 }

   }
}
