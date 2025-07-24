<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use \Exception;
class CategoryController extends Controller
{
    //
    public function index(){
         $categories=Category::paginate(10);
         return response()->json([
            "data"=>$categories
         ],200);
    }
    public function show($id){
        $category=Category::find($id);
        if($category){
            return response()->json([
                "data"=>$category
            ],200);
        }
        else{
             return response()->json([
                "message"=>"Category not found"
            ],404);
        }
    }
    public function store(Request $request){
        try{
            $request->validate([
                "name"=>"required|unique:categories,name",
                "image"=>"required"
            ]);
            $category=new Category();
                if($request->hasFile('image')){
                    $path = "assets/uploads/category/{$category->image}";
                    if(File::exists($path)){
                        File::delete($path);
                    }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $filename= time() . '.' . $ext;
                try{
                    $file->move('assets/uploads/category/', $filename);
                }
                catch(Exception $e){
                    dd($e);
                }
            $category->image=$filename;
            }
            $category->name=$request->name;
            $category->save();
            return response()->json([
                "message"=>"Category added successfully",
                "data"=>$category
                ],201);
            
        }   
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
        }

    }
    public function update($id,Request $request){
        try{
            $request->validate([
                "name"=>"required|unique:categories,name",
                "image"=>"required"
                ]);  
            $category=Category::find($id);
            if($request->hasFile('image')){
                $path = "assets/uploads/category/{$category->image}";
                    if(File::exists($path)){
                        File::delete($path);
                     }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $filename= time() . '.' . $ext;
                try{
                    $file->move('assets/uploads/category/', $filename);
                }
                catch(Exception $e){
                dd($e);
                }
            $category->image=$filename;
            }
            $category->name=$request->name; 
            $category->update();
                return response()->json([
                "message"=>"Category updated successfully",
                'data'=>$category
                    ],200);
        }
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
            } 
  

    }   
    public function destroy($id){
        $category=Category::find($id);
        if($category){
                $category->delete();
                return response()->json([
                    "message"=>"Category deleted successfully"
            ],200);
            }
        else{

            return response()->json([
                "error"=>"Category not found"
                    ],404);
        }
    }
}
