<?php

namespace App\Http\Controllers\Front;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function getDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddress = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddress]);
        }
        return view('front.products.delivery_addresses');
    }

    public function SaveDeliveryAddress(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'delivery_name' =>'required|string|max:100',
                'delivery_address' =>'required|string|max:100',
                'delivery_city' =>'required|string|max:100',
                'delivery_state' =>'required|string|max:100',
                'delivery_country' =>'required|string|max:100',
                'delivery_pincode' =>'required|numeric|digits:6',
                'delivery_mobile' =>'required|numeric|digits:10',
            ]);
             if($validator->passes())
             {
                $data = $request->all();

                $address = array();
                $address['user_id']=Auth::user()->id;
                $address['name']=$data['delivery_name'];
                $address['address']=$data['delivery_address'];
                $address['country']=$data['delivery_country'];
                $address['state']=$data['delivery_state'];
                $address['city']=$data['delivery_city'];
                $address['pincode']=$data['delivery_pincode'];
                $address['mobile']=$data['delivery_mobile'];
                if(!empty($data['delivery_id'])){
                    //Edit Delivery Address
                    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
                }else{
                    //Add Delivery Address
                    // $address['status']==1;
                    DeliveryAddress::create($address);
                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses();
                // echo"<pre>"; print_r($deliveryAddresses); die;
                $countries = Country::where('status', 1)->get()->toArray();
                return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
               ]);
             }else{
                 return response()->json(['type'=>'error','errors'=>$validator->messages()]);
             }

        }

    }

    public function removeDeliveryAddress(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $countries = Country::where('status', 1)->get()->toArray();
            return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
        ]);
        }
    }
}
