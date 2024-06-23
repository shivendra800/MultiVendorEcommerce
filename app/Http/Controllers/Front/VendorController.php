<?php

namespace App\Http\Controllers\Front;

// use Validator;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public function loginRegister()
    {
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request)
    {
            if($request->isMethod('post')){
                 $data=$request->all();
                // echo"<pre>";print_r($data);die;

                //Validation

                $rules =[
                    "name" =>"required",
                    "email" =>"required|email|unique:admins|unique:vendors",
                    "mobile" =>"required|min:10|numeric|unique:admins|unique:vendors",
                    "accept" =>"required"
                ];
                $customMessages =[
                         "name.required" =>"Name is Required",
                         "email.required" =>"mmail is Required",
                         "email.unique" =>" Email Already Exists",
                         "mobile.required" =>"Mobile is Required",
                         "mobile.unique" =>" Mobile Number Already Exists",
                         "accept.required" =>"Please Accept T&C",

                ];
                $validator =Validator::make($data,$rules,$customMessages);
                if($validator->fails()){
                    return Redirect::back()->withErrors($validator);
                }

                DB::beginTransaction();

                // Create Vendor Account

                // Insert the vendor Details in Vendors Table
                $vendor=new Vendor;
                $vendor->name = $data['name'];
                $vendor->mobile =$data['mobile'];
                $vendor->email =$data['email'];
                $vendor->status =0;


                //set Default Timezone to India
                date_default_timezone_set("Asia/Kolkata");
                $vendor->created_at =date("Y-m-d H:i:s");
                $vendor->updated_at =date("Y-m-d H:i:s");
                $vendor->save();

                $vendor_id= DB::getPdo()->lastInsertId();

                 // Insert the vendor Details in Admins Table
                 $admin = new Admin;
                 $admin->type = 'vendor';
                 $admin->vendor_id = $vendor_id;
                 $admin->name = $data['name'];
                 $admin->mobile =$data['mobile'];
                 $admin->email =$data['email'];
                 $admin->password =bcrypt($data['password']);
                 $admin->status =0;


                   //set Default Timezone to India
                date_default_timezone_set("Asia/Kolkata");
                $admin->created_at =date("Y-m-d H:i:s");
                $admin->updated_at =date("Y-m-d H:i:s");
                 $admin->save();

                     //Send Conifirmation Email
                     $email= $data['email'];
                     $messageData=[
                        'email' =>$data['email'],
                        'name' =>$data['name'],
                        'code' =>base64_encode($data['email']),
                     ];
                     Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                         $message->to($email)->subject('Confirm Your Vendor Account');
                     });


                 DB::commit();


                 //Redirection back Vendor With Success Message

                 $message = "Thanks For Registering as Vendor. Please Confirm Your Email To Activate Your Account.";
                 return redirect()->back()->with('success_message',$message);

            }
    }
      public function vendorConfirm($email)
      {
            //Decode Vendor Email
            $email=base64_decode($email);
            // Check  Vendor Email Exists
            $vendorCount = Vendor::where('email',$email)->count();
            if($vendorCount>0)
            {
                // Vendor Email is Already Activated or not
                $vendorDetails=Vendor::where('email',$email)->first();
                if($vendorDetails->confirm == "Yes")
                {
                    $message ="Your Vendor Account Is Already Confirm. You Can Login";
                    return redirect('vendor/login-register')->with('error_message',$message);
                }else{
                    //Update confirm column to Yes in both Admins/ vendor tables to activate account

                    Admin::where('email',$email)->update(['confirm'=>'Yes']);
                    Vendor::where('email',$email)->update(['confirm'=>'Yes']);

                    // Send Register Email

                    $messageData=[
                       'email' =>$email,
                       'name' =>$vendorDetails->name,
                       'mobile' =>$vendorDetails->mobile
                    ];
                    Mail::send('emails.vendor_account_confirmed',$messageData,function($message)use($email){
                        $message->to($email)->subject(' Your Vendor Account is Confirm You Can Login');
                    });


                    //Redirect To vendor Login/Register Page with Success message
                    $message= "Your Vendor Email Account is Confirmed.You Can login and Add your Persona,Business,Bank Details to Activate your Vendor Account
                               to add product";
                      return redirect('vendor/login-register')->with('success_message',$message);
                }
            }
            else{
                abort(404);
            }
      }

}

