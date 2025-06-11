<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterMeasurementKey;

class MasterMeasurementKeyController extends Controller
{
    public function addMeasurementKey(Request $request){
        
    $request->validate([
        'measurement_key_name' => 'required|string|max:255',
    ]);

    $existingKey = MasterMeasurementKey::where('key_name', $request->measurement_key_name)->first();

    if ($existingKey) {
        return redirect()->back()->with(['error','message' => 'Measurement Key Name already exists!']);
    }
    $newKey = new MasterMeasurementKey();
    $newKey->key_name = $request->measurement_key_name;
    $newKey->save();
    return redirect()->back()->with(['success','Measurement Key Name added successfully!']);
  }
}