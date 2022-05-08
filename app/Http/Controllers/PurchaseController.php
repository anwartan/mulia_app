<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\PurchaseRequest;
use App\Models\ProductStock;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isEmpty;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Purchase::getStatusJson();
        $now = Carbon::now()->timestamp;
        return view('layouts.purchase.index',[
            'statusEnum'=>$status,
            'startDate'=> $now,
            'endDate'=> $now,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.purchase.add',[
            "statusEnum"=>Purchase::STATUS,
            "purchase"=>new Purchase(),
            "mode"=>"CREATE"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        return view('layouts.purchase.add',[
            "statusEnum"=>Purchase::STATUS,
            "purchase"=>$purchase,
            "mode"=>"EDIT"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function saveOrder( PurchaseRequest $request)
    {
        

        DB::beginTransaction();
        try {
            if($request->mode=="CREATE"){
                $order = new Purchase;
                $order->po_no = $request->po_no;
                $order->purchase_date = $request->purchase_date;
                $order->status = Purchase::STATUS['PENDING'];
                $order->description = $request->description;
                $order->creater = "admin";
                $order->save();
                $items = $request->items;
                for ($i=0; $i < count($items); $i++) {
                     
                    $order_item = new PurchaseItem;
                    $order_item->order_id = $order->id;
                    $order_item->product_id =$items[$i]['product_id'];
                    $order_item->quantity = $items[$i]['quantity'];
                    $order_item->price = $items[$i]['price'];
                    $order_item->creater = "admin";
                   
                    $order_item->save();
                };
            }else {
                
                $order= Purchase::where("po_no",$request->po_no)->first();
                $order->purchase_date = $request->purchase_date;
                $order->description = $request->description;
              
                $order->save();
                $order->items()->delete();
                $items = $request->items;
                for ($i=0; $i < count($items); $i++) {
                     
                    $order_item = new PurchaseItem;
                    $order_item->order_id = $order->id;
                    $order_item->product_id =$items[$i]['product_id'];
                    $order_item->quantity = $items[$i]['quantity'];
                    $order_item->price = $items[$i]['price'];
                    $order_item->creater = "admin";
                   
                    $order_item->save();
                };
            }
            
           
    
        } catch (\Exception  $e) {
            DB::rollback();
            return ResponseFormatter::error(null,$e->getMessage());

            throw $e;
        }
       
        DB::commit();
        return ResponseFormatter::success(null,"Save successfully");
    }

    public function datagrid(Request $request)
    {
        if($request->ajax()){   
            $data = [];
            if(!empty($request->start_date) && !empty($request->end_date)){
                $start = date($request->start_date);
                $end= date($request->end_date);
                $data = Purchase::whereBetween('purchase_date',[$start,$end])->get();
            }
            
            return DataTables::of($data) 
            ->filter(function ($instance) use ($request) {
                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains($row['status'], $request->get('status')) ? true : false;
                    });
                }

               
            })
            ->make(true);
        }
        
    }

    public function completeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $purchase =Purchase::where('po_no',$request->po_no)->first();
            foreach ($purchase->items as  $item) {
                $stock = ProductStock::where('product_id',$item->product_id)
                                ->where('price',$item->price)
                                ->first();
                if($stock==null){
                    $newStock = new ProductStock();
                    $newStock->product_id=$item->product_id;
                    $newStock->price=$item->price;
                    $newStock->quantity = $item->quantity;
                    $newStock->save();
                }else{
                    
                    $stock->quantity = $stock->quantity + $item->quantity;
                    $stock->save();
                }
            }
            $purchase->status = Purchase::STATUS['COMPLETE'];
            $purchase->save();
        }catch (\Exception  $e) {
            DB::rollback();
            throw $e;
        }
       
        DB::commit();
        return ResponseFormatter::success(null,"Save successfully");
        
    }
    public function cancelOrder(Request $request){
        DB::beginTransaction();
        try {
            $purchase =Purchase::where('po_no',$request->po_no)->first();;
            $purchase->status = Purchase::STATUS['CANCEL'];
            $purchase->save();
        }catch (\Exception  $e) {
            DB::rollback();
            throw $e;
        }
    
        DB::commit();
        return ResponseFormatter::success(null,"Save successfully");

    }
}
