<?php

namespace App\Models;

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
     
    protected $fillable = [
        'transaction_date', 'receipt_no', 'description','status','price','creater','updater','cash_out','cash_out_time'
    ];
    public function getCashOutTimeStringAttribute()
    {
        return Carbon::parse($this->cash_out_time)->format('Y-m-d h:m:s');
    }
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
}
