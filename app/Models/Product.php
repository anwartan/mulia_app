<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $appends = ['status_name'];

    public const STATUS = [
        'ACTIVE'     => 0,
        'DISACTIVE'    => 1
     ];


    protected $fillable = [
        'product_name', 'product_description', 'product_sku','product_status','creater','updater'
    ];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
    public function getStatusNameAttribute(){
    
        return array_search($this->product_status,self::STATUS,true);
    }

    public static function getStatusJson($selected = "ACTIVE"){
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
