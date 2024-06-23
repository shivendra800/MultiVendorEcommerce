<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class SectionController extends Controller
{
    public function sections()
    {
        Session::put('page', 'sections');
        $sections = Section::get()->toArray();
        return view('admin.sections.section')->with(compact('sections'));
    }

    public function UpdateSectionStatus(Request $request)
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
            Section::where('id', $data['section_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'section_id' => $data['section_id']]);
        }
    }
    public function DeleteSection($id)
    {
        Section::where('id', $id)->delete();
        $message = "Section has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditSection(Request $request, $id = null)
    {
        Session::put('page', 'sections');
        if ($id == "") {
            $title = "Add Section";
            $section = new Section;
            $message = "Section Add Successfully!";
        } else {
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section Update Successfully!";
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u'
            ];

            $customMessages = [
                'section_name.required' => 'Name is Requried',
                'section_name.regex' => 'valid name is requires',
            ];
            $this->validate($request, $rules, $customMessages);

            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();



            return redirect('admin/sections')->with('success_message', $message);
        }
        //  echo "test"; die;
        return view('admin.sections.add_edit_section')->with(compact('title', 'section'));
    }
}
