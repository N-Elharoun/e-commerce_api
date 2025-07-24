<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;


class LocationController extends Controller
{
    //
    public function store(Request $request){
        try{
            $request->validate([
                'area'=>'required',
                'street'=>'required',
                'building'=>'required'
            ]);
        }
        catch(ValidationException $e){
            return response()->json(["errors"=>$e->errors()],422);
        }
        $location = new Location();
        $location->area=$request->area;
        $location->street=$request->street;
        $location->building=$request->building;
        $location->user_id=Auth::id();
        $location->save();
        return response()->json([
            "message"=>"Location added successfully",
            'data'=>$location
        ],201);
    }

    public function update($id,Request $request){
        try{
            $request->validate([
                'area'=>'required',
                'street'=>'required',
                'building'=>'required'
            ]);
        }
        catch(ValidationException $e){
            return response()->json(["errors"=>$e->errors()],422);
        }
        $location=Location::find($id);
        if($location){
            $location->update([
                'area'=>$request->area,
                'street'=>$request->street,
                'building'=>$request->building,
             ]);
            return response()->json([
                "message"=>"Location updated successfully",
                "data"=>$location
            ],200);
            
        }
        else{
            return response()->json(["message"=>"Location Not found"],404);

        }

    }

    public function destroy($id){
        $location = Location::find($id);
        if ($location) {
            $location->delete();
            return response()->json(["message" => "Location deleted successfully"], 200);
        } else {
            return response()->json(["message" => "Location Not found"], 404);
        }
    }
    
}
