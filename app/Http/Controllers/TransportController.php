<?php

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use App\Models\TransportHalt;
use App\Models\TransportVehicle;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function filterVehicle(Request $request)
    {
        //
        $data=$request->all();

        $route = TransportRoute::find($data['route']);
        $vehicles = TransportVehicle::with('transportRoutes')->whereHas('transportRoutes', function ($query) use ($data){
                $query->where('transport_route_id', $data['route']);
            })->where('status', '1')->orderBy('number', 'asc')->get();
        $fee_id = $route->fee_id;
        $halts = TransportHalt::where('route_id', $data['route'])->select('id','name')->get();
        $data = [
            'vehicles' => $vehicles,
            'halts' => $halts,
            'fee_id' => $fee_id
        ];

        return response()->json($data);
    }
}
