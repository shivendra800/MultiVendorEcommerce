<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function UserOrder($id=null)
    {
        if(empty($id)){
            $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            // dd($orders);
            return view('front.orders.user_order')->with(compact('orders'));
        }else{
           $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        //    dd( $orderDetails);
        return view('front.orders.user_order_details')->with(compact('orderDetails'));
        }

    }
}
