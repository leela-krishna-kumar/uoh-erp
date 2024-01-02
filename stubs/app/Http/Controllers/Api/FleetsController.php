<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fleets;
use Illuminate\Support\Facades\Validator;

class FleetsController extends Controller
{
    private $resultLimit = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $fleets = Fleets::query();
            $fleets =  $fleets->select('id','driver_id', 'name','plate_no','status','updated_at')->with('user',function($q){
                $q->select('id','first_name','last_name','email','phone');
            })
            ->latest()->limit(1)
                ->offset(($page - 1) * $limit)->get();
            //response
            if($fleets){
                return $this->success($fleets); 
            }else{
                return $this->error('Fleets Data Does not exist!'); 
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
    public function show($id)
    {
        try {
            $fleets = Fleets::where('id',$id)->select('id','driver_id', 'name','plate_no','status','updated_at')->with('user',function($q){
                $q->select('id','first_name','last_name','email','phone');
            })->first();
            //response
            if($fleets){
                return $this->success($fleets); 
            }else{
                return $this->error('Fleets Data Does not exist!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function updateFleetsStatus(Request $request, $id)
    {
        try {

            $fleets = Fleets::where('id',$id)->first();
            //response
            if($fleets){
                $validator = Validator::make($request->all(), [
                    'status' => ['required', 'numeric', 'in:0,1'],
                ], [
                    'status.in' => 'The status field must be either 0 or 1.',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Sorry! Failed to validate data!',
                        'errors' => $validator->errors(),
                    ], 422);
                }
                $chk = $fleets->update($request->all());
                return $this->success($fleets); 
            }else{
                return $this->error('Fleets Data Does not exist!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

}
