<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;


class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'location_id',
        'status',
        'total_price',
        'date_of_delivery'
    ];
    public function user(){
       return $this->belongsTo(User::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                ->withPivot('quantity', 'price');
               // ->withTimestamps();
    }
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
}
