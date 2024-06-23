<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categorys()
    {
        Session::put('page', 'categories');
        $categorys = Category::with(['section', 'parentcategory'])->get()->toArray();
        // dd($categorys);
        return view('admin.categorys.category')->with(compact('categorys'));
    }

    public function addEditCategorys(Request $request, $id = null)
    {
        Session::put('page', 'categories');
        if ($id == "") {
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "categorys Add Successfully!";
        } else {
            $title = "Edit categorys";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $category['section_id']])->get();
            $message = "categorys Update Successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u'
            ];

            $customMessages = [
                'category_name.required' => 'Name is Requried',
                'category_name.regex' => 'valid name is requires',
            ];
            $this->validate($request, $rules, $customMessages);

            if ($data['category_discount'] == "") {
                $data['category_discount'] = 0;
            }

            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/category_image/' . $imageName;
                    //Upload The Image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            } else {
                $category->category_image = "";
            }

            $category->category_name = $data['category_name'];
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_image = $imageName;
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();



            return redirect('admin/categories')->with('success_message', $message);
        }

        $getSections = Section::get()->toArray();
        return view('admin.categorys.add_edit_categorys')->with(compact('title', 'category', 'getSections', 'getCategories'));
    }

    public function UpdateCategorysStatus(Request $request)
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
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function appendcategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $data['section_id']])->get()->toArray();
            return view('admin.categorys.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function Deletecategorys($id)
    {
        Category::where('id', $id)->delete();
        $message = "Category has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }
    public function DeletecategorysImage($id)
    {
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        // Get category Image Path
        $category_image_path = 'front/images/category_image/';

        //Delete Category Image form Category _image folder if exists
        if (file_exists($category_image_path . $categoryImage->category_image)) {
            unlink($category_image_path . $categoryImage->category_image);
        }
        //Deleted catwgory Image form category Floader
        Category::where('id', $id)->update(['category_image' => '']);
        $message = "Category Image has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }
}
