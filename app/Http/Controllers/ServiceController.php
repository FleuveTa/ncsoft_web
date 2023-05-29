<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index () {

        $page = new Page();
        $data = $page->getDataService();
        
        return view('pages/service', ['data' => $data]);
    }
}
