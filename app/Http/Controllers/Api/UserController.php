<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function signup(Request $request){
    	//Validate Request
    	$this->validate($request, [
    		'fast_name'	=> 'required',
    		'last_name'	=> 'required',
    		'user_name'	=> 'required|unique:users,user_name',
    		'nic'		=> 'required',
    		'email'		=> 'required|email|unique:users,email',
    		'mobile_munber'	=> 'required|numeric|unique:users,mobile_munber',
    		'city'		=> 'required',
    		'district'	=> 'required',
    		'password'	=> 'required',
    	]);

    	//Create New User
    	$newUser = User::create([
    		'fast_name'	=> $request->fast_name,
    		'last_name'	=> $request->last_name,
    		'user_name'	=> $request->user_name,
    		'nic'		=> $request->nic,
    		'email'		=> $request->email,
    		'mobile_munber'	=> $request->mobile_munber,
    		'city'		=> $request->city,
    		'district'	=> $request->district,
    		'password'	=>  bcrypt($request->password),
    	]);

    	//API Response
    	if ($newUser) {
    		return response()->json([
	            'status'=> 'success',
	            'data'	=> $newUser
	        ], 200);
    	}else{
			return response()->json([
	            'status'=> 'failed',
	        ], 400);
    	}
    }


    public function signin(Request $request){
    	//Validate Request
    	$valid_credential = $this->validate($request, [
    		'user_name'	=> 'required',
    		'password'	=> 'required',
    	]);


    	if (Auth::attempt($valid_credential)) {

	        //Generate Access Token
	         $accessToken = auth()->user()->createToken('mediApp')->accessToken;

	        return response()->json([
	              'status'    => 'success',
	              'access_token'  => $accessToken,
	          ], 200);
    	             
	    }else{
          return response()->json([
              'status'    => 'failed'
          ], 400);
	    }

    }
}
