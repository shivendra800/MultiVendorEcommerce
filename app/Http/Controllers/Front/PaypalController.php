<?php

namespace App\Http\Controllers\Front;

use Omnipay\Omnipay;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    private $gatway;

    public function __construct()
    {
        $this->gatway = Omnipay::create('PayPal_Rest');
        $this->gatway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gatway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gatway->setTestMode(true);
    }
    public function paypal()
    {
        if(Session::has('order_id')){
            return view('front.paypal.paypal');
        }else{
            return redirect('cart');
        }
    }
    public function pay(Request $request)
    {
        try{
            $paypal_amount = round(Session::get('grand_total')/80,2);
            $response = $this->gatway->purchase(array(
                'amount' =>$paypal_amount,
                'currency'=>env('PAYPAL_CURRENCY'),
                'returnUrl'=>url('success'),
                'cancelUrl'=>url('error')
            ))->send();
            if($response->isRedirect()){
                $response->redirect();
            }else{
                return $response->getMessage();
            }
                }catch (\Throwable $th){
                    return $th->getMessage();
                }
    }
    public function success(Request $request)
    {
        if($request->input('paymentId') && $request->input('PayerID')){
            $transaction = $this->gatway->completePurchase(array(
                'payer_id'=>$request->input('PayerID'),
                'transactionReference'=>$request->input('paymentId')
            ));
            $response = $transaction->send();
            if($response->isSuccessful()){
                $arr=$response->getData();
                $payment= new Payment;
                $payment->order_id=Session::get('order_id');
                $payment->user_id=Auth::user()->id;
                $payment->payment_id=$arr['id'];
                $payment->payer_id=$arr['payer']['payer_info']['payer_id'];
                $payment->payer_email=$arr['payer']['payer_info']['email'];
                $payment->amount=$arr['transaction']['0']['amount']['total'];
                $payment->currency= env('PAYPAL_CURRENCY');
                $payment->payment_status=$arr['state'];
                $payment->save();   
                // return "Payment is Successful.Your Transaction is". $arr['id'];  
                //updated The Order
                $order_id=Session::get('order_id');
                //updated Order Status
                Order::where('id',$order_id)->update(['order_status'=>'Paid']);
                $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                //Email 
                $email = Auth::user()->email;
                $messageData =[
                    'email' =>$email,
                    'name' =>Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageData,function($message)use($email){
                    $message->to($email)->subject('Order Place Successfully!- Shivendra Developers.com');
                });

                 //Reduce Stock  Script Starts 
                 foreach($orderDetails['orders_products'] as $key => $order){
                    $getProductStock = ProductsAttribute::isStockAvailable($order['product_id'],$order['product_size']);
                    $newStock=  $getProductStock - $order['product_qty'];
                    ProductsAttribute::where(['product_id'=>$order['product_id'],'size'=>$order['product_size']])->update([
                      'stock'=>$newStock]);
                 }
              
                     //Reduce Stock  Script Ends 
                       //Empty the Cart
               Carts::where('user_id',Auth::user()->id)->delete();
               return view('front.paypal.success');
            }else{
                return $response->getMessage();
            }
        }else{
            return "Payment Declined";
        }
    }

    public function error(){
        return "USer Declined the payment";
    }
}
