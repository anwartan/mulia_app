<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemOperate extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','order_item_id',  'product_stock_id','product_id', 'quantity','price','creater','updater'
    ];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
