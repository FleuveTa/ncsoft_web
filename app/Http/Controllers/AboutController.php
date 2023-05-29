<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;
use App\Models\Page;

class AboutController extends Controller
{
    public function index() {
        $page = new Page();
        $data = $page->getDataAbout();
        
        return view('pages/aboutUs', ['data' => $data]);
    }
}
