<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Error;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

use App\Models\Vendor;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\VendorsBankDetail;
use App\Http\Controllers\Controller;

use function GuzzleHttp\json_encode;
use App\Models\VendorsBusinessDetail;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        // echo  $password = Hash::make('123456'); die;  *just use for encrypted password that you first time enter in data base *
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";*use this for formating the debugging code*
            // print_r($data);
            // die;
            // laravel validation
            // $validated = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]);
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            // this is custome meg
            $custommesg = [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',

            ];
            $this->validate($request, $rules, $custommesg);

            // if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
            //     return redirect('admin/dashboard');
            // } else {
            //     return redirect()->back()->with('error_message', 'Invalid Email or Password');
            // }

            // if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']]))
            //  {
            //     if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm="No")
            //     {
            //         return redirect()->back()->with('error_message', 'Please Confirm Your email To Activate Your Vendor Account');
            //     }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0")
            //     {
            //         return redirect()->back()->with('error_message', 'Your Admin Account Is not Active');
            //     }else{
            //         return redirect('admin/dashboard');
            //     }
            // } else {
            //     return redirect()->back()->with('error_message', 'Invalid Email or Password');
            // }
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                if (Auth::guard('admin')->user()->type == "vendor" && Auth::guard('admin')->user()->confirm == "No") {
                    return redirect()->back()->with('error_message', 'Please Confirm Your email To Activate Your Vendor Account');
                } else if (Auth::guard('admin')->user()->type != "vendor" && Auth::guard('admin')->user()->status == "0") {
                    return redirect()->back()->with('error_message', 'Your Admin Account Is not Active');
                } else {
                    return redirect('admin/dashboard');
                }
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password');
            }
        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    public function Update_Admin_Password(Request $request)
    {
        Session::put('page', 'update_admin_password');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //check If Current Password enterted by admin is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //Check if New Password is matching with conifrm Password
                if ($data['confirm_pasword'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Your  Password Is Updated Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Your New Password is Not Match With Confirm Password');
                }
            } else
                return redirect()->back()->with('error_message', 'Your Current Password Is Incorrect');
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.setting.update_admin_password')->with(compact('adminDetails'));
    }

    public function CheckAdminPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // die;
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function Update_Admin_Details(Request $request)
    {
        Session::put('page', 'update_admin_details');
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
            ];
            $this->validate($request, $rules, $customMessages);

            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photos/' . $imageName;
                    //Upload The Image
                    Image::make($image_tmp)->save($imagePath);
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = "";
            }
            //Admin  Details Update
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name' => $data['admin_name'], 'mobile' => $data['admin_mobile'],
                'image' => $imageName
            ]);
            return redirect()->back()->with('success_message', 'Admin Details Updated Successfully');
        }
        return view('admin.setting.update_admin_details');
    }

    public function Update_Vendor_Details($slug, Request $request)
    {
        Session::put('page', 'Update_Vendor_Details');
        if ($slug == "personal") {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric',
                    'vendor_country' => 'required|',
                    'vendor_state' => 'required|',
                    'vendor_city' => 'required|',
                    'vendor_address' => 'required|',
                    'vendor_pincode' => 'required|numeric',
                ];
                $customMessages = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_name.regex' => 'Valid Name is required',
                    'vendor_mobile.required' => 'Mobile is required',
                    'vendor_mobile.numeric' => 'Valid Mobile is required',
                ];
                $this->validate($request, $rules, $customMessages);

                if ($request->hasFile('vendor_image')) {
                    $image_tmp = $request->file('vendor_image');
                    if ($image_tmp->isValid()) {
                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/photos/' . $imageName;
                        //Upload The Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } elseif (!empty($data['current_vendor_image'])) {
                    $imageName = $data['current_vendor_image'];
                } else {
                    $imageName = "";
                }
                //Update Vendor details in admins table
                Admin::where('id', Auth::guard('admin')->user()->id)->update([
                    'name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'],
                    'image' => $imageName
                ]);
                //Update Vendor details in vendor table
                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update([
                    'name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'], 'address' => $data['vendor_address'], 'city' => $data['vendor_city'],
                    'state' => $data['vendor_state'], 'country' => $data['vendor_country'], 'pincode' => $data['vendor_pincode']

                ]);
                return redirect()->back()->with('success_message', 'Vendor Details Updated Successfully');
            }
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } elseif ($slug == "business") {

            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'shop_country' => 'required|',
                    'shop_state' => 'required|',
                    'shop_city' => 'required|',
                    'shop_address' => 'required|',
                    'shop_pincode' => 'required|numeric',
                ];
                $customMessages = [
                    'shop_name.required' => 'Name is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Valid Mobile is required',
                ];
                $this->validate($request, $rules, $customMessages);

                if ($request->hasFile('address_proof_image')) {
                    $image_tmp = $request->file('address_proof_image');
                    if ($image_tmp->isValid()) {
                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/proofs/' . $imageName;
                        //Upload The Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } elseif (!empty($data['current_address_proof_image'])) {
                    $imageName = $data['current_address_proof_image'];
                } else {
                    $imageName = "";
                }
                $vendorCount = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    //Update Vendor Business  details in VendorsBusinessDetail table
                    VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                        'shop_name' => $data['shop_name'], 'shop_mobile' => $data['shop_mobile'], 'shop_address' => $data['shop_address'], 'shop_city' => $data['shop_city'],
                        'shop_state' => $data['shop_state'], 'shop_country' => $data['shop_country'], 'shop_pincode' => $data['shop_pincode'],
                        'shop_website' => $data['shop_website'], 'address_proof' => $data['address_proof'], 'business_license_number' => $data['business_license_number'],
                        'gst_number' => $data['gst_number'], 'pan_number' => $data['pan_number'], 'address_proof_image' => $imageName,

                    ]);
                } else {
                    //Inster Vendor Business  details in VendorsBusinessDetail table
                    VendorsBusinessDetail::insert([
                        'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                        'shop_name' => $data['shop_name'], 'shop_mobile' => $data['shop_mobile'], 'shop_address' => $data['shop_address'], 'shop_city' => $data['shop_city'],
                        'shop_state' => $data['shop_state'], 'shop_country' => $data['shop_country'], 'shop_pincode' => $data['shop_pincode'],
                        'shop_website' => $data['shop_website'], 'address_proof' => $data['address_proof'], 'business_license_number' => $data['business_license_number'],
                        'gst_number' => $data['gst_number'], 'pan_number' => $data['pan_number'], 'address_proof_image' => $imageName,

                    ]);
                }



                return redirect()->back()->with('success_message', 'Vendor Bussiness Details Updated Successfully');
            }
            $vendorCount = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else {
                $vendorDetails = array();
            }
        } elseif ($slug == "bank") {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'account_number' => 'required|numeric',
                    'bank_name' => 'required|',
                    'bank_ifsc_code' => 'required|',

                ];
                $customMessages = [
                    'account_holder_name.required' => 'Name is required',
                    'account_holder_name.regex' => 'Valid Name is required',
                    'account_number.required' => 'Mobile is required',
                    'account_number.numeric' => 'Valid Mobile is required',
                ];
                $this->validate($request, $rules, $customMessages);


                $vendorCount = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    //Update Vendor Business  details in VendorsBusinessDetail table
                    VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                        'account_holder_name' => $data['account_holder_name'], 'account_number' => $data['account_number'], 'bank_name' => $data['bank_name'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                    ]);
                } else {
                    //Insert Vendor Business  details in VendorsBusinessDetail table
                    VendorsBankDetail::insert([
                        'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                        'account_holder_name' => $data['account_holder_name'], 'account_number' => $data['account_number'], 'bank_name' => $data['bank_name'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                    ]);
                }

                return redirect()->back()->with('success_message', 'Vendor Bank Details Updated Successfully');
            }
            $vendorCount = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else {
                $vendorDetails = array();
            }
        }
        $countries = Country::where('status', 1)->get()->toArray();
        return view('admin.setting.update_vendor_details')->with(compact('slug', 'vendorDetails', 'countries'));
    }

    public function admins($type = null)
    {

        $admins = Admin::query();
        if (!empty($type)) {
            $admins = $admins->where('type', $type);
            $title = ucfirst($type) . "s";
            Session::put('page', 'view_' . strtolower($title));
        } else {
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page', 'view_all');
        }
        $admins = $admins->get()->toArray();
        // dd($admins);
        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }
    public function ViewVendorDetails($id)
    {

        $vendorDetails = Admin::with('vendorPersonal', 'vendorBusiness', 'vendorBank')->where('id', $id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails), true);
       //  dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function UpdateAdminStatus(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            $adminDetails = Admin::where('id', $data['admin_id'])->first()->toArray();
            if ($adminDetails['type'] == "vendor" && $status == "1") {
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status' => $status]);
                //Send Approvel Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                ];
                Mail::send('emails.vendor_approved', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject(' Your Vendor Account is Approved');
                });
            }
            $adminType = Auth::guard('admin')->user()->type;
            return response()->json(['status' => $status, 'admin_id' => $data['admin_id']]);
        }
    }
}
