<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceLog;
use Illuminate\Support\Facades\Validator;
use App\Models\Fleets;

class DeviceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$fleetId)
    {
        try {
            $fleet = Fleets::where('id',$fleetId)->first();
            //response
            if($fleet){
                $deviceLog = DeviceLog::query();
                $deviceLog =  $deviceLog->with('fleet')->where('fleet_id',$fleet->id)->latest()->first();
                //response
                if($deviceLog){
                    return $this->success($deviceLog); 
                }else{
                    return $this->error('Device Log Data Does not exist!'); 
                }
            }else{
                return $this->error('Fleet Data Does not exist!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $fleetId)
    {
        try {
            $fleet = Fleets::where('id',$fleetId)->first();
            //response
            if($fleet){
                $validator = Validator::make($request->all(), [
                    'coordinates' => 'required',
                    'location' => 'required',
                    'status' =>  ['required', 'numeric', 'in:0,1,2'],
                ], [
                    'status.in' => 'The status field must be either 0 , 1 or 2.',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Sorry! Failed to validate data!',
                        'errors' => $validator->errors(),
                    ], 422);
                }
                // $deviceLog = DeviceLog::where('fleet_id',$fleet->id)->first();
                // if($deviceLog){
                //     $deviceLog->coordinates = $request->coordinates;
                //     $deviceLog->location = $request->location;
                //     $deviceLog->status = $request->status;
                //     $deviceLog->save();
                // }else{
                // }
                $deviceLog = New DeviceLog;
                $deviceLog->fleet_id = $fleet->id;
                $deviceLog->coordinates = $request->coordinates;
                $deviceLog->location = $request->location;
                $deviceLog->status = $request->status;
                $deviceLog->save();
                return $this->success($deviceLog); 
            }else{
                return $this->error('Fleet Data Does not exist!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
  
}
