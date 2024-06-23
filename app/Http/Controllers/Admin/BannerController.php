<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function Banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
          return view('admin.banners.banner')->with(compact('banners'));
    }

    public function DeleteBanner($id)
    {
        $bannerImage=  Banner::where('id', $id)->first();

        //Get Banner Image Path
        $bannner_image_path='front/images/banner_images/';

        //Delete banner image from folder if it exist
        if(file_exists($bannner_image_path.$bannerImage->image)){
              unlink($bannner_image_path.$bannerImage->image);
        }
        //Delete Banner from Banner table
        Banner::where('id', $id)->delete();
        $message = "Banner Image has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function AddBannerImage(Request $request, $id = null)
    {
        Session::put('page', 'banners');
        if ($id == "") {
            $title = "Add Banner";
            $banner = new Banner;
            $message = "Banner Add Successfully!";
        } else {
            $title = "Edit banner";
            $banner = Banner::find($id);
            $message = "banner Update Successfully!";
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            if($data['type']=="slider"){
                $width="1920";
                $height="720";
            } elseif($data['type']=="Fix"){
                $width= "1920";
                $height="450";
            }

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {

                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/banner_images/' . $imageName;
                    //Upload The Image
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                }
            } else if (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = "";
            }

            $banner->type = $data['type'];
            $banner->title = $data['title'];
            $banner->link = $data['link'];
             $banner->image=$imageName;
            $banner->alt = $data['alt'];
            $banner->status = 1;

            $banner->save();



            return redirect('admin/banners')->with('success_message', $message);
        }
        //  echo "test"; die;
        return view('admin.banners.add_edit_banners')->with(compact('title', 'banner'));
    }
}
