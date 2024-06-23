<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function product()
    {
        Session::put('page', 'products');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == "vendor") {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect("admin/update-vendor-details/personal")->with('error_message', 'Your Vendor Account Is Not Approve Yet.Please Make Sure To Fill Personal ,Business And Bank Details Of Your Acccount.');
            }
        }
        $products = Product::with([
            'section' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'category_name');
            }
        ]);
        if ($adminType == "vendor") {
            $products = $products->where('vendor_id', $vendor_id);
        }
        $products = $products->get()->toArray();
        return view('admin.products.product')->with(compact('products'));
    }

    public function addEditProduct(Request $request, $id = null)
    {
        Session::put('page', 'products');
        if ($id == "") {
            $title = "Add Product";
            $product = new Product;
            $message = "Product Add Successfully!";
        } else {
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product Update Successfully!";
        }




        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // print_r(Auth::guard('admin')->user());
            // die;

            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'category_id' => 'required|',
                'product_code' => 'required|',
                'product_price' => 'required|',
                'product_video'  => 'mimes:mp4,mov,ogg | max:20000'

            ];

            $customMessages = [
                'product_name.required' => 'Product Name is Requried',
                'product_name.regex' => 'valid Product name is requires',
                'product_code.required' => 'Product code is Requried',

                'product_price.required' => 'Product Price is Requried',
                'category_id.required' => 'Category id is Requried',
                'product_video'    => 'Product_video  is Requried'

            ];
            $this->validate($request, $rules, $customMessages);

            //Upload Product Image After Resize small :250x250, Mesium:500X500 , Large:1000X1000

            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image After resize
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_image/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_image/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_image/small/' . $imageName;
                    //Upload The Large,Medium Small Images after resize
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);
                    $product->product_image = $imageName;
                }
            } elseif (!empty($data['current_product_image'])) {
                $imageName = $data['current_product_image'];
            } else {
                $imageName = "";
            }
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    //Get video Extension

                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111, 99999) . '.' . $extension;
                    $videoPath = 'front/videos/product_video/';
                    $video_tmp->move($videoPath, $videoName);
                    //Inster video name

                    $product->product_video = $videoName;
                }
            } elseif (!empty($data['current_product_video'])) {
                $videoName = $data['current_product_video'];
            } else {
                $videoName = "";
            }

            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $filter) {
                // echo $data[$filter['filter_column']];
                // die;
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $data['category_id']);
                if ($filterAvailable == "Yes") {
                    if (isset($filter['filter_column']) && $data[$filter['filter_column']]) {
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }

            if (empty($data['product_discount'])) {
                $data['product_discount'] == 0;
            }

            if (empty($data['product_weight'])) {
                $data['product_weight'] == 0;
            }

            $product->product_name =  $data['product_name'];
            $product->product_code =  $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->group_code =    $data['group_code'];
            $product->product_price = $data['product_price'];
            $product->product_image = $imageName;
            $product->product_video = $videoName;
            $product->product_discount = $data['product_discount'];
            $product->product_weight =  $data['product_weight'];
            $product->description =     $data['description'];
            $product->meta_title =      $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords =    $data['meta_keywords'];
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }
            if (!empty($data['is_bestseller'])) {
                $product->is_bestseller = $data['is_bestseller'];
            } else {
                $product->is_bestseller = "No";
            }
            $product->status = 1;
            $product->save();



            return redirect('admin/products')->with('success_message', $message);
        }
        //Get Section with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();
        //   dd($categories);
        $brands = Brand::where('status', 1)->get()->toArray();
        //  echo "test"; die;
        return view('admin.products.add_edit_product')->with(compact('title', 'product', 'categories', 'brands'));
    }
    public function DeleteProduct($id)
    {
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function UpdateProductStatus(Request $request)
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
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function addAttributes(Request $request, $id)
    {
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('attributes')->find($id);
        // $product=json_decode(json_encode($product),true);
        // dd($product);

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // SKU Duplicate Check
                    $skuCount = ProductsAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', 'SKU Already exists! Please add Another SKU!');
                    }

                    //Size Duplicate Check
                    // $sizeCount=ProductsAttribute::where(['product_id'=>$id,'size',$data['size'][$key]])->count();
                    // // dd($sizeCount);
                    // if($sizeCount>0){
                    //     return redirect()->back()->with('error_message','size Already exists! Please add Another size!');
                    // }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    //          echo "<pre>";
                    // print_r($attribute);
                    // die;
                    $attribute->save();
                    $attribute->status = 1;
                    //          echo "<pre>";
                    // print_r($attribute);
                    // die;
                }
            }
            return redirect()->back()->with('success_message', 'Product Attributies Add Successfully!');
        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributesStatus(Request $request)
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
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }
    public function Deleteattribute($id)
    {
        ProductsAttribute::where('id', $id)->delete();
        $message = "Products Attribute has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function Editattribute(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            //    echo "<pre>";
            // print_r($data);
            // die;
            foreach ($data['attributeId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductsAttribute::where(['id' => $data['attributeId'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message', 'Product Attribute has been Updated successfully!');
        }
    }

    public function AddImage(Request $request, $id)
    {
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('images')->find($id);
        //   $product=json_decode(json_encode($product),true);
        // dd($product);
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                //  echo"<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {

                    $image_tmp = Image::make($image);

                    $image_name = $image->getClientOriginalName();
                    //Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    //Generate New Image After resize
                    $imageName = $image_name . rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_image/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_image/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_image/small/' . $imageName;
                    //Upload The Large,Medium Small Images after resize
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    $image = new ProductsImage;
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message', 'Product Image has been Updated successfully!');
        }

        return view('admin.images.add_images')->with(compact('product'));
    }

    public function updateImageStatus(Request $request)
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
            ProductsImage::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }
    public function DeleteImage($id)
    {
        ProductsImage::where('id', $id)->delete();
        $message = "Products Image has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }
}
