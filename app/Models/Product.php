<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'category_id',
        'brand_id',
        'is_trendy',
        'is_available',
        'price',
        'amount',
        'discount',
        'image'
    ];
    public function category(){
       return $this->belongsTo(Category::class);
    }
     public function brand(){
       return $this->belongsTo(Brand::class);
    }
     public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                ->withPivot('quantity', 'price')
                ->withTimestamps();
    }
     protected $hidden=[
        'created_at',
        'updated_at'
    ];
}
