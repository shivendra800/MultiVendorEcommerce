<?php

namespace App\Http\Controllers\Front;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    public function cmsPage()
    {
        $currentRoute=url()->current();
         $currentRoute= str_replace("http://127.0.0.1:8000/","",$currentRoute);
         $cmsRoutes =CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
         if(in_array($currentRoute,$cmsRoutes)){
                 $cmsPageDetails = CmsPage::where('url',$currentRoute)->first()->toArray();
                  return view('front.pages.cms_page')->with(compact('cmsPageDetails'));
         }else{
            abort(404);
         }
    }
}
