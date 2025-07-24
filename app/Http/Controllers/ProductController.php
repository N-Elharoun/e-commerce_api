<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Exception;
class ProductController extends Controller
{
    //
    public function index(){
        $products=Product::paginate(10);
        if($products){
            return response()->json(["Data"=>$products],200);
        }
        else {
            return response()->json(["Message"=>"There are no products"],200);
        }
    }
    public function show($id){
        $product=Product::find($id);
        if($product){
             return response()->json(["Data"=>$product],200);
        }
        else {
            return response()->json(["Message"=>"Product not found"],404);
        }
    }
    public function store(Request $request){
        try{
            $request->validate([
                'name'=>'required',
                'price'=>'required',
                'category_id'=>'required',
                'brand_id'=>'required',
                'amount'=>'required',
                'discount'=>'required',
                'image'=>'required'
            ]);
            $product=new Product();
              if($request->hasFile('image')){
                    $path = "assets/uploads/product/{$product->image}";
                    if(File::exists($path)){
                        File::delete($path);
                    }
                $file=$request->file('image');
                $ext=$file->getClientOriginalExtension();
                $filename= time() . '.' . $ext;
                try{
                    $file->move('assets/uploads/product/', $filename);
                }
                catch(Exception $e){
                    dd($e);
                }
                $product->image=$filename;
            }

            $product->name=$request->name;
            $product->category_id=$request->category_id;
            $product->brand_id=$request->brand_id;
            $product->price=$request->price;
            $product->amount=$request->amount;
            $product->discount=$request->discount;
            $product->save();
            return response()->json([
                "message"=>"Product added successfully",
                "data"=>$product
                ],201);
        }
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
        
        }

    }
    public function update($id,Request $request){
        try{
            $request->validate([
                'name'=>'required',
                'price'=>'required',
                'category_id'=>'required',
                'brand_id'=>'required',
                'amount'=>'required',
                'discount'=>'required',
                'image'=>'required'
            ]);
            $product=Product::find($id);
            if($product){
                  if($request->hasFile('image')){
                    $path = "assets/uploads/product/{$product->image}";
                    if(File::exists($path)){
                        File::delete($path);
                    }
                    $file=$request->file('image');
                    $ext=$file->getClientOriginalExtension();
                    $filename= time() . '.' . $ext;
                    try{
                        $file->move('assets/uploads/product/', $filename);
                    }
                    catch(Exception $e){
                        dd($e);
                    }
                    $product->image=$file;
                }
                $product->name=$request->name;
                $product->category_id=$request->category_id;
                $product->brand_id=$request->brand_id;
                $product->price=$request->price;
                $product->amount=$request->amount;
                $product->discount=$request->discount;
                $product->update();
                return response()->json([
                    "message"=>"Product updated successfully",
                    "data"=>$product
                    ],200);
            }
            else {
                return response()->json(["Message"=>"Product not found"],404);
            }
        }
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
        }
    }
    public function destroy($id){
        $product=Product::find($id);
        if($product){
            $product->delete();
            return response()->json(["Message"=>"Product deleted successfully"],200);

        }
        else {
            return response()->json(["Message"=>"Product not found"],404);
        }
    }
}
