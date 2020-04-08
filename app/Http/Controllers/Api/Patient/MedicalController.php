<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Medical;

class MedicalController extends Controller
{
    public function search($keyword)
    {
    	if (!empty($keyword)) {
    		$result  = Medical::Where('city', 'like', '%'.$keyword.'%')
    			->orWhere('center_name', 'like', '%'.$keyword.'%')
    	        ->orWhere('dr_name', 'like', '%'.$keyword.'%')->get();

    	    if ($result) {
	    		return response()->json([
		            'status' => 'success',
		            'data'	 => $result
		        ], 200);

    	                    	
    	    }else{
	    		return response()->json([
		            'status'=> 'no result found',
		        ], 204);
    	    }                
    	}else{

    		return response()->json([
	            'status'=> 'failed',
	        ], 400);
    	}


    }
}
