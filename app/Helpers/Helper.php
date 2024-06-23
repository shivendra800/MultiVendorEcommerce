<?php

use App\Models\Carts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

    function totalCartItems(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $totalCartItems = Carts::where('user_id',$user_id)->sum('quantity');

        }else{
            $session_id = Session::get('session_id');
            $totalCartItems=Carts::where('session_id',$session_id)->sum('quantity');
        }
        return $totalCartItems;
    }

   function getCartItems()
    {
       if(Auth::check())
       {
        // If user Logged In/pick auth id of user
        $getCartItems=Carts::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image');
        }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
       }else{
        // if user not logged in/pick session_id of the user
        $getCartItems=Carts::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image');
        }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();

       }
       return $getCartItems;
    }

?>
