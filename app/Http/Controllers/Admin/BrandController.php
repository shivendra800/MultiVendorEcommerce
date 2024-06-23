<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function Brands()
    {
        Session::put('page', 'brands');
        $brands = Brand::get()->toArray();
        return view('admin.brands.brand')->with(compact('brands'));
    }

    public function UpdateBrandStatus(Request $request)
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
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'brand_id' => $data['brand_id']]);
        }
    }
    public function DeleteBrand($id)
    {
        Brand::where('id', $id)->delete();
        $message = "brand has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditBrand(Request $request, $id = null)
    {
        Session::put('page', 'brands');
        if ($id == "") {
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand Add Successfully!";
        } else {
            $title = "Edit brand";
            $brand = Brand::find($id);
            $message = "Brand Update Successfully!";
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u'
            ];

            $customMessages = [
                'brand_name.required' => 'Name is Requried',
                'brand_name.regex' => 'valid name is requires',
            ];
            $this->validate($request, $rules, $customMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();



            return redirect('admin/brands')->with('success_message', $message);
        }
        //  echo "test"; die;
        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand'));
    }
}
