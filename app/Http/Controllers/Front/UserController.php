<?php

namespace App\Http\Controllers\Front;
use App\Models\Sms;
use App\Models\User;
use App\Models\Carts;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginRegister()
    {
        return view('front.user.login_register');
    }
    public function userRegister(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            //  echo"<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(),[
                'name'=>'required|string|max:60',
                'mobile'=>'required|numeric|digits:10',
                'email' =>'required|email|max:150|unique:users',
                'password'=>'required|min:6',
                'accept' =>'required'
            ],

            [
                'accept.required'=>'Please Accept our Terms & Conditions'
            ]
        );
           if($validator->passes()){
                  // Register New User
                    $user = new User;
                    $user->name =$data['name'];
                    $user->mobile =$data['mobile'];
                    $user->email =$data['email'];
                    $user->password =bcrypt($data['password']);
                    $user->status =0;
                    $user->save();

                       /* Activate the user only when the user confirm his email account */
                       $email = $data['email'];
                       $messageData = ['name'=>$data['name'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                       Mail::send('emails.user_register_confirmation',$messageData,function($message)use($email){
                        $message->to($email)->subject('Confirm Your  Shivendra Developers Account');
                       });

                       //Redirect back user with success message
                       $redirectTo = url('user/login-register');
                       return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Please confirm your email to activate your account!']);
                    /* Activate the user stright way without sending any confirmation email*/

                       // Send Email
                    //    $email =$data['email'];
                    //    $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                    //    Mail::send('emails.user_register',$messageData,function($message)use($email){
                    //     $message->to($email)->subject('Welcome To Shivendra Developers');
                    // });

                     // Send Mobile Sms
                    //  $message = "Dear Customer,You Have Been Succrssfully Registered With Shivendra Developoers.Login to your account to access orders,address and available offrers.";
                    //  $mobile = $data['mobile'];
                    //  Sms:sendSms($message,$mobile);
                  /*  if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                        $redirectTo = url('cart');
                           // Update User Cart with user ID
                     if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Carts::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                  }
                        return response()->json(['type'=>'success','url'=>$redirectTo]);
                    } */
           }else{
                  return response()->json(['type'=>'error','errors'=>$validator->messages()]);
           }
        }
    }

    public function UserLogin(Request $request)
    {
        if($request->ajax()){
           $data = $request->all();
         //  echo"<pre>"; print_r($data); die;

           $validator = Validator::make($request->all(),[
            'email' =>'required|email|max:150|exists:users',
            'password'=>'required|min:6',
                ]);

            if($validator->passes()){
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                     if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Your Account Is not activated!.Please Confirm your account to activate your account.']);
                     }

                     // Update User Cart with user ID
                     if(!empty(Session::get('session_id'))){
                           $user_id = Auth::user()->id;
                           $session_id = Session::get('session_id');
                           Carts::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                     }
                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Incorrect Email Or Password!']);
             }


            }else{
                  return response()->json(['type'=>'error','errors'=>$validator->messages()]);
           }
        }
    }

    public function UserLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function UserConfirmAccount($code)
    {
        //Decode Vendor Email
        $email=base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if($userCount>0){
                   $userDetails = User::where('email',$email)->first();
                   if($userDetails->status==1){
                    //Redirect the user to login/Register Page with error message
                    return redirect('user/login-register')->with('error_message','Your email account is already activated.You can login Now.');
                   }else{
                       User::where('email',$email)->update(['status'=>1]);
                         //   Send Welcome Email
                       $messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$email];
                       Mail::send('emails.user_register',$messageData,function($message)use($email){
                        $message->to($email)->subject('Welcome To Shivendra Developers');
                    });
                    return redirect('user/login-register')->with('success_message','Your email account is  activated.You can login Now.');

                   }
        }else{
            abort(404);
        }
    }

    public function forgetPassword(Request $request)
    {
        if($request->ajax()){
            $data= $request->all();
          //  echo"<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'email' =>'required|email|max:150|exists:users',
            ],
            [
                'email.exists'=>'Email Does Not Exists!'
            ]
                );

                if($validator->passes()){
                    // gerenter new password
                    $new_password = Str::random(16);
                    //update password
                    User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);
                    // Get user Details
                    $userDetails = User::where('email',$data['email'])->first()->toArray();
                    //send email to user
                    $email = $data['email'];
                    $messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$email,'password'=>$new_password];
                    Mail::send('emails.user_forgot_password',$messageData,function($message)use($email){
                     $message->to($email)->subject('New Password-  Shivendra Developers');
                 });

                 return response()->json(['type'=>'success','message'=>'New Password Sent To Your Register Email']);

                }else{
                    return response()->json(['type'=>'error','errors'=>$validator->messages()]);
                }


        }else{
            return view('front.user.forget_password');
        }


    }

    public function userAccount(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();
          //  echo"<pre>"; print_r($data); die;
          $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:60',
            'mobile'=>'required|numeric|digits:10',
            'city'=>'required|string|max:60',
            'state'=>'required|string|max:60',
            'country'=>'required|string|max:60',
            'pincode'=>'required|numeric|digits:6',
            'address'=>'required|string|max:80',
        ],
       );
          if($validator->passes()){
                     // update User Details
                     User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],
                     'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                     //Reidrect back user message
                     return response()->json(['type'=>'success','message'=>'Your Contact Details Has Been Updated successfully .']);
          }else{
            return response()->json(['type'=>'error','errors'=>$validator->messages()]);
          }
        }
        else{
            $countries=Country::where('status',1)->get()->toArray();
            return view('front.user.user_account')->with(compact('countries'));
        }


    }

    public function userUpdatePassword(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();
          //  echo"<pre>"; print_r($data); die;
          $validator = Validator::make($request->all(),[
            'current_password'=>'required|',
            'new_password'=>'required|min:6',
            'confirm_password'=>'required|min:6|same:new_password',
        ],
       );
          if($validator->passes()){
                    $current_password = $data['current_password'];
                    $checkPassword = User::where('id',Auth::user()->id)->first();
                    if(Hash::check($current_password,$checkPassword->password)){
                        //Update New Password
                        $user = User::find(Auth::user()->id);
                        $user->password = bcrypt($data['new_password']);
                        $user->save();
                        return response()->json(['type'=>'success','message'=>'Your Account Password is Change Successfully.']);
                    }else{
                         //Reidrect back error message
                     return response()->json(['type'=>'incorrect','message'=>'Your Password IS Incorrect .']);
                    }


                     //Reidrect back user message
                     return response()->json(['type'=>'success','message'=>'Your Contact Details Has Been Updated successfully .']);
          }else{
            return response()->json(['type'=>'error','errors'=>$validator->messages()]);
          }
        }
        else{
            $countries=Country::where('status',1)->get()->toArray();
            return view('front.user.user_account')->with(compact('countries'));
        }


    }
}
