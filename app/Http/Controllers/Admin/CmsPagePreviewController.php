<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Cms;

class CmsPagePreviewController extends Controller
{
    public function index($cms_slug = null)
    {
        $cmsPageData = Cms::where('slug',$cms_slug)->first();
        return view('Admin/cms_page_preview/cms_page')->with(compact('cmsPageData'));
    }

    public  function term(Request $request){
        $response['status'] = 0;
        $cmsPageData = Cms::where('slug','term')->first();
        if($cmsPageData != ''){
            $response['status'] = 1;
            $response['cmsPageData'] = $cmsPageData;
        }
        echo json_encode($response);
        exit;
    }
}