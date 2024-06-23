<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Symfony\Component\CssSelector\Node\FunctionNode;

class CmsController extends Controller
{
    public function cmsPages()
    {
        $cmsPages = CmsPage::get()->toArray();
        return view('admin.cmsPages.cmsPages_list')->with(compact('cmsPages'));
    }
    public function DeleteCmsPage($id)
    {
        CmsPage::where('id', $id)->delete();
        $message = "Cms Page has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }
    public function UpdateCmsPageStatus(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();

            if($data['status']=="Active"){
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }
    public function AddEditCmsPages(Request $request,$id="null")
    {
        Session::put('page', 'cms-Page');
        if ($id == "") {
            $title = "Add Cms Page";
            $CmsPage = new CmsPage;
            $message = "CmsPage Add Successfully!";
        } else {
            $title = "Edit CmsPage";
            $CmsPage = CmsPage::find($id);
            $message = "CmsPage Update Successfully!";
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'title' => 'required|regex:/^[\pL\s\-]+$/u'
            ];

            $customMessages = [
                'title.required' => 'Name is Requried',
                'title.regex' => 'valid name is requires',
            ];
            $this->validate($request, $rules, $customMessages);

            $CmsPage->title = $data['title'];
            $CmsPage->description = $data['description'];
            $CmsPage->url =str_replace(' ', '-', $data['url']);
            $CmsPage->meta_title = $data['meta_title'];
            $CmsPage->meta_description = $data['meta_description'];
            $CmsPage->meta_keywords = $data['meta_keywords'];
            $CmsPage->status = 1;
            $CmsPage->save();
            return redirect('admin/cms-Page')->with('success_message', $message);
        }
        return view('admin.cmsPages.add_edit_cmspages')->with(compact('title','CmsPage'));
    }

}
