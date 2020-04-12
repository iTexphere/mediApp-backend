<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Medical;

class MedicalController extends Controller
{
    public function medicalSearch(Request $request)
    {   

        if( !isset($request->city) && !isset($request->center_name) && !isset($request->dr_name) ){

            return response()->json([
                'status'    => 'faild'
            ], 422);

        }elseif ( isset($request->city) && !isset($request->center_name) && !isset($request->dr_name) ) {
           $result = Medical::where('city', $request->city)->get();

        }elseif ( isset($request->city) && isset($request->center_name) && !isset($request->dr_name) ) {
           
           $result = Medical::where([
                ['city', '=' ,$request->city],
                ['center_name','=' ,$request->center_name]
           ])->get();

        }elseif (isset($request->city) && isset($request->center_name) && isset($request->dr_name)) {
            
            $result = Medical::where([
                 ['city', '=', $request->city],
                 ['center_name', '=', $request->center_name],
                 ['dr_name', 'like', '%'.$request->dr_name.'%' ],
            ])->get();

        }elseif ( isset($request->city) && !isset($request->center_name) && isset($request->dr_name)  ) {
            $result = Medical::where([
                 ['city', '=', $request->city],
                 ['dr_name', 'like', '%'.$request->dr_name.'%' ],
            ])->get();
            
        }elseif (!isset($request->city) && isset($request->center_name) && isset($request->dr_name) ) {
            $result = Medical::where([
                 ['center_name', '=', $request->center_name],
                 ['dr_name', 'like', '%'.$request->dr_name.'%' ],
            ])->get();

        }elseif (!isset($request->city) && !isset($request->center_name) && isset($request->dr_name)) {
            $result = Medical::where('dr_name', 'like', '%'.$request->dr_name.'%')->get();

        }elseif (!isset($request->city) && isset($request->center_name) && !isset($request->dr_name)) {
            $result = Medical::where('center_name', '=', '$request->center_name')->get();

        }else{

            return response()->json([
                'status'=> 'faild',
            ], 400);
        }


        if ($result) {
            return response()->json([
                'status' => 'success',
                'data'   => $result
            ], 200);

        }else{

            return response()->json([
                'status'=> 'not found',
            ], 204);
        }


    }
}
