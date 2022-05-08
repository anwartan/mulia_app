<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Product::getStatusJson();
    
        return view('layouts.product.index',[
            'statusEnum'=>$status,
          
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.product.add',[
            "statusEnum"=>Product::STATUS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data  = $request->all();
        $data['creater'] = 'admin';
        $result = Product::create($data);
        
        return redirect()->back()->with('status','Product was created successful!');
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
    public function edit(Product $product)
    {
        return view('layouts.product.edit',[
            'statusEnum'=>Product::STATUS,
            'product'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request,Product $product)
    {
        $data  = $request->all();
        $data['updater'] = 'admin';
        $product->update($data);
        return redirect()->back()->with('status','Product was updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->withInput();
    }

    public function datagrid(Request $request)
    {
        if($request->ajax()){
            // dd($request->has('start_date'));
            $data = [];
            // if(!empty($request->start_date) && !empty($request->end_date)){
            //     $start = date($request->start_date);
            //     $end= date($request->end_date);
            //     $data = Order::all();
            // }
            
            $data = Product::all();
            
            return DataTables::of($data) 
            ->filter(function ($instance) use ($request) {
                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains($row['product_status'], $request->get('status')) ? true : false;
                    });
                }
                return true;

               
            })
            ->make(true);
        }
        
    }

    public function products(Request $request)
    {   
        $name = $request->query('product_name');
        $per_page = $request->query('per_page');
        $data = Product::where("product_name","like",'%'.$name .'%')->paginate(
            $perPage =$per_page, $columns = ['*'], $pageName = 'page'
        );
       
        return $data;
    }
}
