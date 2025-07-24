<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Location;
use Exception;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['user:id,name','products'])->get();
        if ($orders->isEmpty()) {
              return response()->json([
                "message"=>"There are no orders"
            ],404);
        }
        else{
           return response()->json([
                "data" => $orders
            ], 200);
        }
    }
    public function show($id){
        $order=Order::with('user:id,name','products')->find($id);
        if($order){
            return response()->json([
                "data"=>$order
            ],200);
        }
        else{
             return response()->json([
                "message"=>"Order not found"
            ],404);
        }
    }
    public function store(Request $request){
        try{
            $request->validate([
                'status'=>'required',
                'total_price'=>'required',
                'date_of_delivery'=>'required',
                'order_items'=>'required'
            ]);
            $location = Location::where('user_id', auth()->id())->first();
            $order = new Order();
            $order->user_id = auth()->id();
            $order->location_id = $location->id;
            $order->status = $request->status;
            $order->total_price = $request->total_price;
            $order->date_of_delivery = $request->date_of_delivery;
            $order->save();
            if (is_array($request->order_items)) {
                $orderItems = $request->order_items;
                foreach ($orderItems as $item) {
                    if (
                        isset($item['product_id']) &&
                        isset($item['quantity']) &&
                        isset($item['price'])
                    ) {
                        $order->orderItems()->create([
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    } else {
                        return response()->json([
                            "error" => "Each order item must have product_id, quantity, and price"
                        ], 422);
                    }
                }
            } else {
                return response()->json([
                    "error" => "Order_items should be an array",
                ], 422);
            }
            return response()->json([
                "message"=>"Order added successfully",
                "data"=>$order
                ],201);
            
        }   
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
        }
    }
    public function update($id,Request $request){
        try{
            $request->validate([
               'status'=>'required',
                'total_price'=>'required',
                'date_of_delivery'=>'required',
                'order_items'=>'required'
            ]);  
            $order=Order::find($id);
            if($order){
                $location=Location::where('user_id',auth()->id())->first();
                $order->user_id=auth()->id();
                $order->location_id=$location->id;
                $order->status=$request->status;
                $order->total_price=$request->total_price;
                $order->date_of_delivery=$request->date_of_delivery;
                $order->save();
                if (is_array($request->order_items)) {
                $orderItems = $request->order_items;
                foreach ($orderItems as $item) {
                    if (
                        isset($item['product_id']) &&
                        isset($item['quantity']) &&
                        isset($item['price'])
                    ) {
                        $order->orderItems()->create([
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    } else {
                        return response()->json([
                            "error" => "Each order item must have product_id, quantity, and price"
                        ], 422);
                    }
                }
            } else {
                return response()->json([
                    "error" => "Order_items should be an array",
                ], 422);
            }
                return response()->json([
                    "message"=>"Order updated successfully",
                    "data"=>$order
                    ],200);
            }
            else{
                return response()->json([
                    "message"=>"Order not found"
                    ],404);
            }

        }
        catch(Exception $e){
                return response()->json(["errors"=>$e->getMessage()],422);
            } 
  

    }   
    public function destroy($id){
        $order=Order::find($id);
        if($order){
                $order->delete();
                return response()->json([
                    "message"=>"Order deleted successfully"
            ],200);
            }
        else{

            return response()->json([
                "message"=>"Order not found"
                    ],404);
        }
    }
}

