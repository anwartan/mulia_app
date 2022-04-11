<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

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
        return view('layouts.order.index',[
            'statusEnum'=>$status,
            'startDate'=>Carbon::now()->timestamp,
            'endDate'=>Carbon::now()->timestamp,
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
    public function destroy($id)
    {
        //
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
}
