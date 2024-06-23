<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductsFiltersValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class FilterController extends Controller
{
    public function filters()
    {
        Session::put('page', 'filters');
        $filters = ProductsFilter::get()->toArray();
        // dd($filters);
        return view('admin.filters.filters')->with(compact('filters'));
    }
    public function filtersValues()
    {
        Session::put('page', 'filters-values');
        $filters_values = ProductsFiltersValue::get()->toArray();
        // dd($filters);
        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    public function UpdateFilterStatus(Request $request)
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
            ProductsFilter::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }

    public function UpdateFilterValuesStatus(Request $request)
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
            ProductsFiltersValue::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }
    public function DeleteFilter($id)
    {
        ProductsFilter::where('id', $id)->delete();
        $message = "Filter has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }
    public function DeleteFilterValues($id)
    {
        ProductsFiltersValue::where('id', $id)->delete();
        $message = "Filter Values has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditFilter(Request $request, $id = null)
    {
        Session::put('page', 'filters');
        if ($id == "") {
            $title = "Add filter";
            $filter = new ProductsFilter;
            $message = "filter Add Successfully!";
        } else {
            $title = "Edit filter";
            $filter = ProductsFilter::find($id);
            $message = "filter Update Successfully!";
        }



        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // $rules = [
            //     'filter_name' => 'required|regex:/^[\pL\s\-]+$/u'
            // ];

            // $customMessages = [
            //     'filter_name.required' => 'Name is Requried',
            //     'filter_name.regex' => 'valid name is requires',
            // ];
            // $this->validate($request, $rules, $customMessages);
            $cat_ids = implode(',', $data['cat_ids']);

            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->cat_ids = $cat_ids;
            $filter->status = 1;
            $filter->save();

            // Add Filter Column in products Table
            DB::statement('Alter table products add ' . $data['filter_column'] . ' varchar(255) after description');
            return redirect('admin/filters')->with('success_message', $message);
        }
        $categories = Section::with('categories')->get()->toArray();
        //  echo "test"; die;
        return view('admin.filters.add_edit_filter')->with(compact('title', 'filter', 'categories'));
    }

    public function addEditFilterValue(Request $request, $id = null)
    {
        Session::put('page', 'filters');
        if ($id == "") {
            $title = "Add filter";
            $filter = new ProductsFiltersValue();
            $message = "filter Value Add Successfully!";
        } else {
            $title = "Edit filter";
            $filter = ProductsFiltersValue::find($id);
            $message = "filter Value Update Successfully!";
        }



        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;



            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status = 1;
            $filter->save();


            return redirect('admin/filters-values')->with('success_message', $message);
        }
        $filters = ProductsFilter::where('status', 1)->get()->toArray();
        //  echo "test"; die;
        return view('admin.filters.add_edit_filter_value')->with(compact('title', 'filter', 'filters'));
    }

    public function categoryFilters(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $category_id = $data['category_id'];
            // dd($category_id);
            return response()->json(['view' => (string)View::make('admin.filters.category_filters')->with(compact('category_id'))]);
        }
    }
}