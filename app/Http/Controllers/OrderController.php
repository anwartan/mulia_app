<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOperate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Order::getStatusJson();
        $now = Carbon::now()->timestamp;
      
        return view('layouts.order.index',[
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
        //
        return view('layouts.order.add',[
            "statusEnum"=>Order::STATUS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {   
        $data  = $request->all();
        $data['creater'] = 'admin';
        Order::create($data);
        return redirect()->back()->with('status','Order was created successful!');
    }

 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        
        $status = Order::getStatusJson();
        return view('layouts.order.edit',[
            'statusEnum'=>Order::STATUS,
            'order'=>$order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request,Order $order)
    {
        $data  = $request->all();
        $data['updater'] = 'admin';
        $order->update($data);
        return redirect()->back()->with('status','Order was updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->withInput();
    }

    public function saveOrder(Request $request){
        DB::beginTransaction();

        try {
            if($request->mode=="CREATE"){
                $order = new Order;
                $order->transaction_date = $request->transaction_date;
                $order->receipt_no=$request->receipt_no;
                $order->description=$request->description;
                $order->status=$request->status;
                $order->price=$request->price;
                $order->creater = "admin";
                $order->save();
                $items = $request->items;
                
                for ($i=0; $i < count($items); $i++) {
                     
                    $order_item = new OrderItemOperate;
                    $order_item->order_id = $order->id;
                    $order_item->product_id =$items[$i]['product_id'];
                    $order_item->quantity = $items[$i]['quantity'];
                    $order_item->price = $items[$i]['price'];
                    $order_item->creater = "admin";
                   
                    $order_item->save();
                };
            }else if($request->mode=="CREATE"){
                $order = new Order;
                $order->transaction_date = $request->transaction_date;
                $order->receipt_no=$request->receipt_no;
                $order->description=$request->description;
                $order->status=$request->status;
                $order->price=$request->price;
                $order->creater = "admin";
            }
        }catch (\Exception  $e) {
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
            // dd($request->has('start_date'));
            $data = [];
            if(!empty($request->start_date) && !empty($request->end_date)){
                $start = date($request->start_date);
                $end= date($request->end_date);
                $data = Order::whereBetween('transaction_date',[$start,$end])->get();
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

    public function print(Request $request)
    {   
        $orders = [];
        $total = 0;
        if(!empty($request->start_date) && !empty($request->end_date) && !empty($request->status)){
            $start = date($request->start_date);
            $end= date($request->end_date);
            $status = $request->status;
            $orders = Order::whereBetween('transaction_date',[$start,$end])->where('status', $status)->get();
            $total = DB::table('orders')
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->where('status', $status)
            ->sum('price');
        }
        
       
        $data= [
            'orders'=>$orders,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'total'=>$total
        ];  
        $pdf = PDF::loadView('./layouts/template/order', $data);
    
        return $pdf->stream('itsolutionstuff.pdf');

    }
}
