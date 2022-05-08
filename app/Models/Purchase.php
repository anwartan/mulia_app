<?php

namespace App\Models;

use App\Helpers\CodeGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Purchase extends Model
{
    use HasFactory;
    protected $appends = ['status_name'];
    private const DOCUMENT_INITIAL = "PO";
    private const REDIS_KEY ="purchase_order";
    public const STATUS = [
        'COMPLETE'     => 1,
        'CANCEL'    => 2,
        'PENDING' =>3
     ];

     protected $fillable = [
        'purchase_date',  'status','description','creater','updater'
    ];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
    public function getStatusNameAttribute(){
    
        return array_search($this->status,self::STATUS,true);
    }

  
    public static function getStatusJson($selected = "PENDING"){
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
            if($model->po_no==null){
                $date = Carbon::now()->format('dmY');
                $model->po_no = self::DOCUMENT_INITIAL.$date.sprintf( '%04d',CodeGenerator::generate(self::REDIS_KEY));    
            }
        });
    }


    public function items()
    {
        return $this->hasMany(PurchaseItem::class,'order_id');
    }
}
