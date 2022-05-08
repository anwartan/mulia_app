<?php

namespace App\Models;

use App\Helpers\CodeGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

   
    public const STATUS = [
        'ON PROGRESS'     => 0,
        'CANCELED'    => 1,
        'COMPLETED'=>2
     ];

     protected $appends = ['status_name'];
     private const DOCUMENT_INITIAL = "SO";
     private const REDIS_KEY ="sales_order";
 
    protected $fillable = [
        'transaction_date', 'receipt_no', 'description','status','price','creater','updater'
    ];
 
    public function getCreatedAtStringAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d h:m:s');
    }
    public function getStatusNameAttribute(){
    
        return array_search($this->status,self::STATUS,true);
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
    
    public static function getStatusJson($selected = "ON PROGRESS"){
        $new = [];
        foreach (self::STATUS as $key => $value) {
            $isSelected =false;
            if($selected==$key){
                $isSelected=true;
            }
            $temp = [
                "id"=>$key,
                "value"=>$value,
                "selected"=>$isSelected
            ];
            array_push($new,$temp);
        };
        return $new;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if($model->order_no==null){
                $date = Carbon::now()->format('dmY');
                $model->order_no = self::DOCUMENT_INITIAL.$date.sprintf( '%04d',CodeGenerator::generate(self::REDIS_KEY));    
            }
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class,'order_id');
    }
}
