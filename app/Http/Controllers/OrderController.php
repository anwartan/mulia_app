<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

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
       
        if(isset($data['cash_out'])){
            $data['cash_out_time'] = Carbon::now();
        }
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
    public function update(Request $request,Order $order)
    {
        $data  = $request->all();
        $data['updater'] = 'admin';
        if(isset($data['cash_out'])){
            $data['cash_out_time'] = Carbon::now();
        }else{
            $data['cash_out']="0";
        }
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

    public function datagrid(Request $request)
    {
        if($request->ajax()){
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
                if ($request->has('cash_out')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(!isNull($row['cash_out'])){
                            return str_contains($row['cash_out'], $request->get('cash_out')) ? true : false;
                        }
                        return true;
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
        if(isset($request->start_date) && isset($request->end_date) && isset($request->cash_out)){
            $start = date($request->start_date);
            $end= date($request->end_date);
            $status = $request->status;
            $cash_out = $request->cash_out;
            $orders = Order::whereBetween('transaction_date',[$start,$end]) ->where('cash_out' , $cash_out)->get();
            $total = DB::table('orders')
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->where('cash_out' , $cash_out)
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
