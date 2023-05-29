<?php

namespace App\Http\Controllers;
// use Yajra\Datatables\Datatables;

use App\Models\Recruitment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class demoController extends Controller
{
    public function index() {
        return view('admin/demo/listDemo');
    }
    public function getData() {
       $recruitment = Recruitment::all()->toArray();
        return DataTables::of($recruitment)
        ->editColumn('description_vn', function ($recruitment) {
            return '<div class="three-line-paragraph-description">'.$recruitment['description_vn'].'</div>';
        })
        ->editColumn('description_en', function ($recruitment) {
            return '<div class="three-line-paragraph-description">'.$recruitment['description_en'].'</div>';
        })
        ->addColumn('action', function ($recruitment) {

            $html  = 
            '<div class="dropdown">'.
                    '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                        'Action'.
                    '</button>'.
                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                        '<a '.
                            'class="dropdown-item" '.
                            'href="'.route("admin.recruitmentEdit", ["id" => $recruitment['id']]) .'"'.
                        '>'.
                            'Edit'.
                        '</a>'.
                        '<button '.
                            'class="dropdown-item btn__deleteRecruitment" '.
                            'value = "'.$recruitment['id'].'"'.
                                        
                        '>'.
                            'Delete'.
                        '</button>'.
                    '</div>'.
            '</div>';
                return $html;
        })
        ->rawColumns(['description_vn','description_en','action'])
        ->make(true);
    }
}
