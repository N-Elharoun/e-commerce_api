<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use \Illuminate\Validation\ValidationException;
class BrandController extends Controller
{
    //
    public function index(){
        $brands=Brand::paginate(10);
        return response()->json([
            "data"=>$brands
        ],200);
    }

    public function show($id){
        $brand=Brand::find($id);
        if($brand){
            return response()->json([
                "data"=>$brand
            ],200);
        }
        else {
            return response()->json([
                "message"=>"The Brand not found"
            ],404);
        }
    }
    public function store(Request $request){
        try{
           $validated =  $request->validate([
                'name'=>'required|unique:brands,name',
            ]);
        
        }
        catch(validationException $e){
            return response()->json(["errors"=>$e->errors()],422);
        }

        $brand=Brand::create($validated);
        return response()->json([
           "message"=>"Brand stores seccussfully ",
           "data"=>$brand 
        ],201);
    }
    public function update(Request $request , $id){
        try{
                $validated=$request->validate([
                        'name'=>'required|unique:brands,name',
                ]);
        }
        catch(validationException $e){
            return response()->json(["errors"=>$e->errors()],422);
        }
        $brand=Brand::find($id);
        if($brand){
                $brand->update($validated);
                return response()->json([
                    "message"=>'Brand updated successfully',
                    "data" => $brand
                ],200);
        }
        else{
            return response()->json([
                "message"=>"Brand not found"
            ],404);
        }

    }

    public function destroy($id){
        $brand=Brand::find($id);
        if($brand){
            $brand->delete();
            return response()->json([
                    "message"=>"Brand deleted successfully"
            ],200);
        }
        else {
            return response()->json([
                    "message"=>"Brand not found"
            ], 404);
        }
    }

}
