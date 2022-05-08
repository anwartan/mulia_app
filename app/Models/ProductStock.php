<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'price', 'quantity'
    ];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->getPreciseTimestamp(3);
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->getPreciseTimestamp(3);
    }

    public function orders(){
        return $this->hasMany(OrderItem::class,'id','product_stock_id');
    }
 
    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function usedStocks()
    {
        return $this->hasManyThrough(Order::class,OrderItem::class);
    }
}
