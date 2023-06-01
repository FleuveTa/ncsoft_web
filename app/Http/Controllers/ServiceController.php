<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ServiceBox;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index () {
        $page = new Page();
        $data = $page->getDataService();

        $ConstantBox = ServiceBox::Box ?? [];
        return view('pages/service', ['data' => $data, 'boxService'=> $ConstantBox]);
    }
}
