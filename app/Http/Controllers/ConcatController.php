<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Page;
use Illuminate\Http\Request;

class concatController extends Controller
{
    public function index () {

        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';
        $bannerPage = Page::where('page_keyword', 'banner_contact')
        ->select($heading,'image')
        ->first();
        return view('pages/concat', ['bannerPage' => $bannerPage]);
    }


}
