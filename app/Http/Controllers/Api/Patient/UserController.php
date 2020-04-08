<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Patient;
use App\User;

use App\Http\Resources\Patient as PatientResource;

class UserController extends Controller
{
    public function signup(Request $request){
        //Validate Request
        $this->validate($request, [
    		'first_name'=> 'required',
    		'last_name'	=> 'required',
    		'nic'		=> 'required',
    		'email'		=> 'required|email',
    		'mobile_number'	=> 'required|numeric',
    		'city'		=> 'required',
    		'district'	=> 'required',
            
            //Use
            'user_name' => 'required|unique:users,user_name',
            'role'      => ['required', Rule::in(['patient'])],
            'password'  => 'required',
    	]);


    DB::beginTransaction();
    	//Create New User
    	$newUser = User::create([
    		'user_name'	=> $request->user_name,
    		'role'	=> $request->role,
    		'password'	=>  bcrypt($request->password),
    	]);

        $newPatient = Patient::create([

            'user_id'   => $newUser->id,
            'first_name'=> $request->first_name,
            'last_name' => $request->last_name,
            'nic'       => $request->nic,
            'email'     => $request->email,
            'mobile_number' => $request->mobile_number,
            'city'      => $request->city,
            'district'  => $request->district,
        ]);

    	//API Response
    	if ($newUser && $newPatient) {

    DB::commit();
    		return response()->json([
	            'status'=> 'success',
	            'data'	=> [
                    'user_info' => $newUser,
                    'patient_info' => $newPatient
                ]
	        ], 200);
    	}else{

	DB::rollBack();
    		return response()->json([
	            'status'=> 'failed',
	        ], 400);
    	}


    } // End of 'SIGNUP'


    public function signin(Request $request){
    	//Validate Request
    	$valid_credential = $this->validate($request, [
    		'user_name'	=> 'required',
    		'password'	=> 'required',
    	]);


    	if (Auth::attempt($valid_credential)) {

	        //Generate Access Token
	         $accessToken = auth()->user()->createToken('mediApp', ['patient'])->accessToken;

	        return response()->json([
	              'status'         => 'success',
                  'user_info'      => new PatientResource(auth()->user()),
                  'access_token'   => $accessToken
	              ,
	          ], 200);
    	             
	    }else{
          return response()->json([
              'status'    => 'failed'
          ], 400);
	    }

    }



}
