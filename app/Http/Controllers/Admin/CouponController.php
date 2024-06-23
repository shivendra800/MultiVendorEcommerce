<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
     public function Couponds()
    {
        Session::put('page', 'coupons');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == "vendor") {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect("admin/update-vendor-details/personal")->with('error_message', 'Your Vendor Account Is Not Approve Yet.Please Make Sure To Fill Personal ,Business And Bank Details Of Your Acccount.');
            }
            $coupons= Coupon::where('vendor_id', $vendor_id)->get()->toArray();
            //dd( $coupons);
        }else{
            $coupons= Coupon::get()->toArray();
        }
        // dd( $coupons);

        return view('admin.coupons.coupon')->with(compact('coupons'));
    }

    public function UpdateCouponStatus(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();

            if($data['status']=="Active"){
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);

        }
    }

    public function DeleteCoupon($id)
    {
        Coupon::where('id', $id)->delete();
        $message = "Coupon has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function AddEditCoupon(Request $request, $id = null)
    {
        Session::put('page', 'coupons');
        if ($id == "") {
            $title = "Add Coupon";
            $coupon = new Coupon();
            $selCats=array();
            $selBrands=array();
            $selUsers=array();
            $message = "Coupon Add Successfully!";
        } else {
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $selCats=explode(',',$coupon['categories']);
            $selBrands=explode(',',$coupon['brands']);
            $selUsers=explode(',',$coupon['users']);
            $message = "Coupon Update Successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'brands' => 'required',
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required',
                'expire_date' => 'required',
            ];

            $customMessages = [
                'brands.required' => 'Select Brands is Requried',
                'categories.required' => 'Select categories is Requried',
                'coupon_option.required' => 'Select coupon_option is Requried',
                'coupon_type.required' => 'Select coupon_type is Requried',
                'amount_type.required' => 'Select amount_type is Requried',
                'amount.required' => 'Select amount is Requried',
                'expire_date.required' => 'Select expire_date is Requried',


            ];
            $this->validate($request, $rules, $customMessages);

            if(isset($data['categories'])){
                $categories=implode(",",$data['categories']);
            }else{
                $categories="";
            }
            if(isset($data['brands'])){
                $brands=implode(",",$data['brands']);
            }else{
                $brands="";
            }
            if(isset($data['users'])){
                $users=implode(",",$data['users']);
            }else{
                $users="";
            }
            if($data['coupon_option']=="Automatic"){
              $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $adminType =Auth::guard('admin')->user()->type;
            if($adminType=="vendor"){
                $coupon->vendor_id=Auth::guard('admin')->user()->vendor_id;
            }else{
                $coupon->vendor_id=0;
            }
            // echo "<pre>";
            // print_r($data);
            // die;

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->brands = $brands;
            $coupon->users = $users;
             $coupon->coupon_type = $data['coupon_type'];
             $coupon->amount_type = $data['amount_type'];
             $coupon->amount = $data['amount'];
             $coupon->expire_date = $data['expire_date'];
            $coupon->status = 1;
            $coupon->save();



            return redirect('admin/coupons')->with('success_message', $message);
        }
                //Get Section with Categories and Sub Categories
                $categories = Section::with('categories')->get()->toArray();
                $brands = Brand::where('status', 1)->get()->toArray();
                $users=User::select('email')->where('status',1)->get();
        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','brands','categories','users','selCats','selBrands','selUsers'));
    }
}
