<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageConstant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PageController extends Controller
{
    public function index () {
        return view('admin/managerPages/managerPages');

    }

    public function getData () {
        $dataPage = Page::join('users', 'users.id', '=', 'pages.user_id')
                        ->select(
                            'pages.id',
                            'pages.heading_vn',
                            'pages.heading_en',
                            'pages.title_vn',
                            'pages.title_en',
                            'pages.description_vn',
                            'pages.description_en',
                            'pages.image',
                            'pages.icon',
                            'pages.button_vn',
                            'pages.button_en',
                            'users.account_name',
                            'pages.page_keyword',
                            'pages.status'
                        )->get();

        return DataTables::of($dataPage)
        ->editColumn('image', function ($page) {

            $image = $page->image ?? '';
            $url = url('images/pages/'.$image);
            if(!empty($image)) {
                $image = '<img src="'.$url.'" alt="Cover" width="500" height="600">';
                return $image;
            }
            
            return "";

        })
        ->editColumn('description_vn', function ($page) {
            return '<div class="three-line-paragraph-description">'.$page['description_vn'].'</div>';
        })
        ->editColumn('title_vn', function ($page) {
            return '<div class="three-line-paragraph">'.$page['title_vn'].'</div>';
        })
        ->editColumn('title_en', function ($page) {
            return '<div class="three-line-paragraph">'.$page['title_en'].'</div>';
        })
        ->editColumn('description_en', function ($page) {
            return '<div class="three-line-paragraph-description">'.$page['description_en'].'</div>';
        })
        ->editColumn('status', function ($category) {
            if($category->status== 0){
                return '<p class="status__lookup">'.
                        'Active'.
                    '</p>';
                }else {
                    return '<p class="status__nolook">'.
                        'Inactive'.
                    '</p>';
                }
            })
        ->addColumn('action', function ($page) {
            $html  =
                        '<div class="dropdown">'.
                                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Action'.
                                '</button>'.
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                    '<a '.
                                        'class="dropdown-item" '.
                                        'href="'.route("page.editPage", ["id" => $page['id']]) .'"'.
                                    '>'.
                                        'Edit'.
                                    '</a>'.
                                    '<button '.
                                        'class="dropdown-item btn__deletePages" '.
                                        'value = "'.$page['id'].'"'.
                                    '>'.
                                        'Delete'.
                                    '</button>'.
                                '</div>'.
                    '</div>';
                return $html;

        })
        ->rawColumns(['description_vn','description_en','action', 'title_vn', 'title_en', 'status', 'image'])
                            ->make(true);
    }

    public function create () {
        $Pages = PageConstant::Pages ?? [];
        return view('admin/managerPages/addContentPages', ['Pages' => $Pages]);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all() , [
            'heading_vn'=>'max:255',
            'heading_en' => 'max:255',
            'icon' => 'max:255',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $heading_vn = $request->heading_vn ?? '';
            $heading_en = $request->heading_en ?? '';
            $description_vn = $request->description_vn ?? '';
            $description_en = $request->description_en ?? '';
            $button_vn = $request->button_vn ?? '';
            $button_en = $request->button_en ?? '';
            $title_vn = $request->title_vn ?? '';
            $title_en = $request->title_en ?? '';
            $icon = $request->icon ?? '';
            $user_id = $request->user_id ?? '';
            $page_keyword = $request->page ?? '';
            $status = $request->status ?? '';
            try {
                if ($request->hasFile('image')) {
                    $originName = $request->file('image')->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = $fileName . '_' . time() . '.' . $extension;

                    $request->file('image')->move(public_path('images/pages'), $fileName);

                    $data = [
                        'heading_vn' => $heading_vn,
                        'heading_en' => $heading_en,
                        'description_vn' => $description_vn,
                        'description_en' => $description_en,
                        'title_vn' => $title_vn,
                        'title_en' => $title_en,
                        'button_vn' => $button_vn,
                        'button_en' => $button_en,
                        'user_id' => $user_id,
                        'icon' => $icon,
                        'page_keyword' => $page_keyword,
                        'status' => $status,
                        'image' => $fileName,

                    ];
                    Page::create($data);
                    return response([
                        'status' => 0,
                        'message' => 'Add new Content Page is Successfully'
                    ],200);
                }else {
                    $data = [
                        'heading_vn' => $heading_vn,
                        'heading_en' => $heading_en,
                        'description_vn' => $description_vn,
                        'description_en' => $description_en,
                        'title_vn' => $title_vn,
                        'title_en' => $title_en,
                        'button_vn' => $button_vn,
                        'button_en' => $button_en,
                        'user_id' => $user_id,
                        'icon' => $icon,
                        'page_keyword' => $page_keyword,
                        'status' => $status,

                    ];
                    Page::create($data);
                    return response([
                        'status' => 0,
                        'message' => 'Add new Content Page is Successfully'
                    ],200);
                }

            } catch (\Throwable $th) {
                return response([
                    'status' => 3,
                    'message' => 'Add new Content Page is fail',
                    'errCode' => $th
                ],403);
            }
        }

    }


    public function edit (Request $request, string $id) {
        $newDataContentPage = [];
        $id_content_page = $id ?? '';
        $Pages = PageConstant::Pages ?? [];
        if(!empty($id_content_page)) {
            $data_content_page = Page::where('pages.id', $id_content_page)
                                    ->join('users', 'users.id', '=', 'pages.user_id')
                                    ->select(
                                        'pages.id',
                                        'pages.heading_vn',
                                        'pages.heading_en',
                                        'pages.title_vn',
                                        'pages.title_en',
                                        'pages.description_vn',
                                        'pages.description_en',
                                        'pages.image',
                                        'pages.button_vn',
                                        'pages.icon',
                                        'pages.button_en',
                                        'users.account_name',
                                        'pages.page_keyword',
                                        'pages.status'
                                    )->first();
            if(!empty($data_content_page)) {
                $newDataContentPage = $data_content_page->toArray();
            }
            return view('admin/managerPages/editContentPages', ['newDataContentPage'=> $newDataContentPage, 'Pages' =>$Pages]);
        }
    }

    public function update(Request $request, string $id) {
        $validator = Validator::make( $request->all() , [
            'heading_vn'=>'required|max:255',
            'heading_en' => 'required|max:255',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $heading_vn = $request->heading_vn ?? '';
            $heading_en = $request->heading_en ?? '';
            $description_vn = $request->description_vn ?? '';
            $description_en = $request->description_en ?? '';
            $button_vn = $request->button_vn ?? '';
            $button_en = $request->button_en ?? '';
            $title_vn = $request->title_vn ?? '';
            $title_en = $request->title_en ?? '';
            $icon = $request->icon ?? '';
            $page_keyword = $request->page ?? '';
            $status = $request->status ?? '';

            $pages = Page::where('id', $id)->first();
            if($pages) {
                if ($request->hasFile('image')) {

                    try {
                        if (file_exists(public_path('images/pages/'.$pages->image)))
                        {

                            @unlink(public_path('images/pages/'.$pages->image));

                        }
                        $originName = $request->file('image')->getClientOriginalName();
                        $fileName = pathinfo($originName, PATHINFO_FILENAME);
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileName = $fileName . '_' . time() . '.' . $extension;

                        $request->file('image')->move(public_path('images/pages'), $fileName);

                        $data = [
                            'heading_vn' => $heading_vn,
                            'heading_en' => $heading_en,
                            'description_vn' => $description_vn,
                            'description_en' => $description_en,
                            'title_vn' => $title_vn,
                            'title_en' => $title_en,
                            'button_vn' => $button_vn,
                            'button_en' => $button_en,
                            'page_keyword' => $page_keyword,
                            'icon' => $icon,
                            'status' => $status,
                            'image' => $fileName,
                        ];


                            $check = Page::where('id', $id)->update($data);


                            return response([
                                'status' => 0,
                                'message' => 'Update Content Page is successfully!!',
                            ]);
                    } catch (\Throwable $th) {

                        return response([
                            'status' => 3,
                            'message' => 'error',
                            'errCode' => $th,
                        ]);
                    }
                }else {
                    $data = [
                        'heading_vn' => $heading_vn,
                        'heading_en' => $heading_en,
                        'description_vn' => $description_vn,
                        'description_en' => $description_en,
                        'title_vn' => $title_vn,
                        'title_en' => $title_en,
                        'button_vn' => $button_vn,
                        'button_en' => $button_en,
                        'page_keyword' => $page_keyword,
                        'icon' => $icon,
                        'status' => $status,
                    ];


                        $check = Page::where('id', $id)->update($data);


                        return response([
                            'status' => 0,
                            'message' => 'Update Content Page is successfully!!',
                        ]);
                }
            }
        }
    }

    public function destroy (Request $request) {
        $page = Page::find($request->id);
        if($page){
            try {
                $page->delete();
                return response([
                    'status' => 0,
                    'message' => 'Delete Content Page is Successfully'
                ],200);
            } catch (\Throwable $th) {
                return response([
                    'status' => 3,
                    'message' => 'Delete Content Page is fail'
                ],403);
            }
        }
        return response([
            'status' => 4,
            'message' => 'Content Page id not found'
        ],403);
    }

}
