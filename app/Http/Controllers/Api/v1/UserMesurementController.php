<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\UserMeasurement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserMesurementController extends Controller
{

    public function getUserMeasurement(Request $request){
        $userId = Auth::user()->id;

        $user_measurement = UserMeasurement::where('user_id',$userId)->get()->toArray();
                return response()->json([
                    'status' => 'success',
                    'data'=>['user_measurement'=>$user_measurement]
                ]); 
    }
    public function storeMeasurement(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'measurement' => 'required|array',
            ]);
            if($validator->fails()){
                return response()->json(['status' => 201,'message' => $validator->errors()->first()], 201);
            }
            $userId = Auth::user()->id;
            $user_measurements = UserMeasurement::where('user_id', $userId)->get();
            if ($user_measurements->isNotEmpty()) {
                foreach ($request->measurement as $measurement_key_id => $measurement_value) {
                    $user_measurement = $user_measurements->where('measurement_key_id', $measurement_key_id)->first();
                    if ($user_measurement) {
                        $user_measurement->update([
                            'measurement_value' => $measurement_value
                        ]);
                    }
                }
                $user_measurement = UserMeasurement::where('user_id',$userId)->get()->toArray();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Measurement Data Updated Successfully',
                    'data'=>['user_measurement'=>$user_measurement]
                ]); 
            } else {
                    $saved = true;
                    foreach ($request->measurement as $measurement_key_id => $measurement_value) {
                        $user_measurement = new UserMeasurement();
                        $result = $user_measurement->create([
                            'user_id' => $userId,
                            'measurement_key_id' => $measurement_key_id,
                            'measurement_value' => $measurement_value
                        ]);

                        if (!$result) {
                            $saved = false;
                            break;
                        }
                    }

                    if ($saved) {
                        $user_measurement = UserMeasurement::where('user_id',$userId)->get()->toArray();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Measurement Data Saved Successfully',
                            'data'=>['user_measurement'=>$user_measurement]
                        ]);      
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed To Save Measurement Data !',
                        ]);      
                    }
            }
        }catch(\Exception $ex){
            return response()->json(['message' => $ex->getMessage()]);
        }
    }
}