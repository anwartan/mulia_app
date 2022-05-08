<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countOnprogress = Order::where("status","=",Order::STATUS['ON PROGRESS'])->get()->count();
        return view('layouts.dashboard.index',[
            'countOnprogress'=>$countOnprogress,
        ]);
    }
}
