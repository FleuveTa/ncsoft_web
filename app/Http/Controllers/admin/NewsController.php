<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\LogNew;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;


use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/news/managerNews');
    }

    public function getData() {
        $dataNews = News::join('users', 'users.id', '=', 'news.user_id')
                        ->select(
                            'news.id',
                            'news.heading_vn',
                            'news.heading_en',
                            'news.slug',
                            'news.title_vn',
                            'news.title_en',
                            'news.description_vn',
                            'news.description_en',
                            'news.image',
                            'users.account_name',
                            'news.time_display',
                        )->get();
        return DataTables::of($dataNews)
        ->editColumn('image', function ($news) {
            $image = $news->image ?? ' ';
            $url = url('images/news/'.$image);

            $image = '<img src="'.$url.'" alt="Cover" width="500" height="600">';
            return $image;

        })
        ->editColumn('description_vn', function ($news) {
            return '<div class="three-line-paragraph-description">'.$news['description_vn'].'</div>';
        })
        ->editColumn('title_vn', function ($news) {
            return '<div class="three-line-paragraph">'.$news['title_vn'].'</div>';
        })
        ->editColumn('title_en', function ($news) {
            return '<div class="three-line-paragraph">'.$news['title_en'].'</div>';
        })
        ->editColumn('description_en', function ($news) {
            return '<div class="three-line-paragraph-description">'.$news['description_en'].'</div>';
        })
        ->addColumn('action', function ($news) {
            $html = '';
            $permission = Helper::handlePermission();
            if(Gate::check('update', $permission)) {
                if(Gate::check('delete', $permission)) {
                    $html  =
                        '<div class="dropdown">'.
                                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Action'.
                                '</button>'.
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                    '<a '.
                                        'class="dropdown-item" '.
                                        'href="'.route("admin.newEdit", ["id" => $news['id']]) .'"'.
                                    '>'.
                                        'Edit'.
                                    '</a>'.
                                    '<button '.
                                        'class="dropdown-item btn__deleteNews" '.
                                        'value = "'.$news['id'].'"'.
                                    '>'.
                                        'Delete'.
                                    '</button>'.
                                '</div>'.
                    '</div>';
                return $html;

                }
                $html  =
                    '<div class="dropdown">'.
                            '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Action'.
                            '</button>'.
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                '<a '.
                                    'class="dropdown-item" '.
                                    'href="'.route("admin.newEdit", ["id" => $news['id']]) .'"'.
                                '>'.
                                    'Edit'.
                                '</a>'.
                            '</div>'.
                    '</div>';
                return $html;
            }

        })
        ->rawColumns(['image', 'description_vn','description_en','action', 'title_vn', 'title_en'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/news/addNew');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all() , [
            'heading_vn' => 'required',
            'heading_en' => 'required',
            'slug' => 'required',
            'description_vn' => 'required|min:3',
            'description_en' => 'required|min:3',
            'title_vn' => 'required',
            'title_en' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'time_display' => 'required'
        ]);

        if ( !$validator->passes() ) {

            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);

        } else {
                $heading_vn = $request->heading_vn ?? '';
                $heading_en = $request->heading_en ?? '';
                $description_vn = $request->description_vn ?? '';
                $description_en = $request->description_en ?? '';
                $title_vn = $request->title_vn ?? '';
                $title_en = $request->title_en ?? '';
                $user_id = $request->user_id ?? '';
                $slug = $this->createSlug($request->slug) ?? '';
                $time_display = date('Y/m/d',strtotime($request->time_display)) ?? '';

            if($time_display >= date('Y/m/d')){
                try {
                    if ($request->hasFile('image')) {
                        $originName = $request->file('image')->getClientOriginalName();
                        $fileName = pathinfo($originName, PATHINFO_FILENAME);
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileName = $fileName . '_' . time() . '.' . $extension;

                        $request->file('image')->move(public_path('images/news'), $fileName);

                        $data = [
                            'heading_vn' => $heading_vn,
                            'heading_en' => $heading_en,
                            'description_vn' => $description_vn,
                            'description_en' => $description_en,
                            'title_vn' => $title_vn,
                            'title_en' => $title_en,
                            'user_id' => $user_id,
                            'slug' => $slug,
                            'image' => $fileName,
                            'time_display' => $time_display
                        ];
                        News::create($data);
                        return response([
                            'status' => 0,
                            'message' => 'Add new News is Successfully'
                        ],200);
                    }

                } catch (\Throwable $th) {
                    return response([
                        'status' => 3,
                        'message' => 'Add new News is fail'
                    ],405);
                }

            }else {
                return response([
                    'status' => 4,
                    'message' => 'Date display is invalid'
                ],405);
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $newDataNews = [];
        $id_news = $id ?? '';
        if(!empty($id_news)){
            $data_news = News::where('news.id', $id_news)
                                        ->join('users', 'users.id', '=','news.user_id')
                                        ->select(
                                            'news.id',
                                            'news.heading_vn',
                                            'news.heading_en',
                                            'news.slug',
                                            'news.title_vn',
                                            'news.title_en',
                                            'news.description_vn',
                                            'news.description_en',
                                            'news.image',
                                            'users.account_name',
                                            'news.time_display',
                                            )
                                        ->first();
            if(!empty($data_news)) {
                $newDataNews = $data_news->toArray();
            }
            return view('admin/news/editNew', ['newDataNews'=> $newDataNews]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(),[
            'heading_vn' => 'required',
            'heading_en' => 'required',
            'description_vn' => 'required',
            'description_en' => 'required',
            'title_en' => 'required',
            'title_vn' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'time_display' => 'required',
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
                try {
                    $dataNews = News::where('id',$id)->first();
                    if( $dataNews ){
                        if ($request->hasFile('image')) {
                            if (file_exists(public_path('images/news/'.$dataNews->image)))
                            {

                                @unlink(public_path('images/news/'.$dataNews->image));

                            }
                                $originName = $request->file('image')->getClientOriginalName();
                                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                                $extension = $request->file('image')->getClientOriginalExtension();
                                $fileName = $fileName . '_' . time() . '.' . $extension;

                                $request->file('image')->move(public_path('images/news'), $fileName);
                                $data = [
                                    'heading_vn' => $request->heading_vn ?? '',
                                    'heading_en' => $request->heading_en ?? '',
                                    'description_vn' => $request->description_vn ?? '',
                                    'description_en' => $request->description_en ?? '',
                                    'title_vn' => $request->title_vn ?? '',
                                    'title_en' => $request->title_en ?? '',
                                    'slug' => $request->slug ? $this->createSlug($request->slug) : '',
                                    'image' => $fileName,
                                    'time_display' => $request->time_display ? date('Y/m/d',strtotime($request->time_display)) : ''
                                ];

                                if(empty($data['slug'])) {

                                    $data['slug'] = $this->createSlug($data['heading_vn']);
                                }
                                $checkUpdate = News::where('id',$id)->update($data);
                                if($checkUpdate){
                                    LogNew::create([
                                        'user_id' => Auth::id() ?? '',
                                        'status_pass' => '',
                                        'status_future' => 'update',
                                        'new_id' => $id ?? ''
                                    ]);
                                    return response([
                                        'status' => 0,
                                        'message' => 'Update News is Successfully'
                                    ],200);
                                }
                        }else {
                            $data = [
                                'heading_vn' => $request->heading_vn ?? '',
                                'heading_en' => $request->heading_en ?? '',
                                'description_vn' => $request->description_vn ?? '',
                                'description_en' => $request->description_en ?? '',
                                'title_vn' => $request->title_vn ?? '',
                                'title_en' => $request->title_en ?? '',
                                'slug' => $request->slug ? $this->createSlug($request->slug) : '',
                                'time_display' => $request->time_display ? date('Y/m/d',strtotime($request->time_display)) : ''
                            ];

                            if(empty($data['slug'])) {

                                $data['slug'] = $this->createSlug($data['heading_vn']);
                            }
                            $checkUpdate = News::where('id',$id)->update($data);
                            if($checkUpdate){
                                LogNew::create([
                                    'user_id' => Auth::id() ?? '',
                                    'status_pass' => '',
                                    'status_future' => 'update',
                                    'new_id' => $id ?? ''
                                ]);
                                return response([
                                    'status' => 0,
                                    'message' => 'Update News is Successfully'
                                ],200);
                            }
                        }

                    }

                } catch (\Throwable $th) {
                    return response([
                        'status' => 3,
                        'message' => 'Update News is fail',
                        'errCode' => $th
                    ], 405);
                }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $news_id = $request->id ?? '';
        $news = News::where('id', $news_id)->first();
        if($news){
            try {
                $checkDelete = $news->delete();
                if($checkDelete){
                    LogNew::create([
                        'user_id' => Auth::id() ?? '',
                        'status_pass' => 'public',
                        'status_future' => 'trash',
                        'new_id' => $news_id ?? ''
                    ]);

                    return response([
                        'status' => 0,
                        'message' => 'Delete News is Successfully'
                    ], 200);
                }
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete News is fail'
                ]);
            } catch (\Throwable $th) {
                return response([
                    'status' => 3,
                    'message' => 'Error no delete News',
                    'errCodfe' => $th
                ], 405);
            }
        }
        return response([
            'status' => 3,
            'message' => 'delete News is fail'
        ], 404);
    }



    public function createSlug(string $string){
        if(!empty($string)){
            $search = array(
                '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
                '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
                '#(ì|í|ị|ỉ|ĩ)#',
                '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
                '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
                '#(ỳ|ý|ỵ|ỷ|ỹ)#',
                '#(đ)#',
                '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
                '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
                '#(Ì|Í|Ị|Ỉ|Ĩ)#',
                '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
                '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
                '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
                '#(Đ)#',
                "/[^a-zA-Z0-9\-\_]/",
            );
            $replace = array(
                'a',
                'e',
                'i',
                'o',
                'u',
                'y',
                'd',
                'A',
                'E',
                'I',
                'O',
                'U',
                'Y',
                'D',
                '-',
            );
            $string = preg_replace($search, $replace, $string);
            $string = preg_replace('/(-)+/', '-', $string);
            $string = strtolower($string);
        }
        return $string ?? '';
    }
}
