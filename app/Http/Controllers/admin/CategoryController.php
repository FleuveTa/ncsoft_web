<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/categories/managerCategory');
    }

    public function getData () {
        $dataCategory = Category::join('users', 'categories.user_id', '=', 'users.id')
                        ->select(
                                'categories.id',
                                'categories.name_en', 
                                'categories.name_vn', 
                                'categories.slug',
                                'categories.user_id',
                                'categories.status',
                                'users.account_name', 
                                'categories.created_at'
                                )
                        ->get();
        return DataTables::of($dataCategory)
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
                ->editColumn('created_at', function ($category) {
                    $create_at = date_format($category->created_at, "d-m-Y");
                    return $create_at;
                })
                ->addColumn('action', function ($category) {
                        $html = '<td>'.
                                '<div class="dropdown">'.
                                        '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                            'Action'.
                                        '</button>'.
                                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                            '<a '.
                                                'class="dropdown-item" '.
                                                'href="'.route('admin.showedit', ['id'=>$category->id ?? ' ', 'slug'=>$category->slug ?? ' ']).'"'.
                                            '>'.
                                                'Edit'.
                                            '</a>'.
                                            '<button '.
                                                'class="dropdown-item btn__deleteCategory"'.
                                                'value = "'.$category->id.'"'.
                                            '>'.
                                            'Delete'.
                                            '</button>'.
                                        '</div>'.
                                    '</div>'.
                                '</td>';
                        return $html;
                })
                    
            ->rawColumns(['status', 'action'])

                ->make(true);
    }

    // public function getAllCategories(){
    //     $dataCategory = DB::table('categories')
    //                     ->join('users', 'categories.user_id', '=', 'users.id')
    //                     ->select(
    //                             'categories.id',
    //                             'categories.name_en', 
    //                             'categories.name_vn', 
    //                             'categories.slug',
    //                             'categories.user_id',
    //                             'categories.status',
    //                             'users.account_name', 
    //                             'categories.created_at'
    //                             )
    //                     ->get()
    //                     ->toArray();
    //     return $dataCategory;
    // }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name_category_en'=>'required',
            'name_category_vn' => 'required',
        ]);


        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $user_id = $request->user_id??'';
            $name_category_en = $request->name_category_en??'';
            $name_category_vn = $request->name_category_vn??'';
            $slug = $request->slug??'';
            $status = $request->status??'';

            if( !empty($user_id)) {

                if ( empty($slug) ) {

                    $slug = $this->createSlug($name_category_en);
                }else {
                    $slug = $this->createSlug($slug);
                }
                try {
                    $checkCreate = Category::create([
                        'name_en' => $name_category_en,
                        'name_vn' => $name_category_vn,
                        'slug' => $slug,
                        'user_id' => $user_id,
                        'status' => $status
                    ]);
                    if ( $checkCreate)  {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Create New Category was successfully!',
                            'url' => route('admin.category')
                        ]);
                    }
                    return response()->json([
                        'status' => 1,
                        'message' => 'Create New Category was fail!'
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => 3,
                        'message' => 'Create New Category was fail!',
                        'errCode' => $th
                    ]);
                }
            }
            return response()->json([
                'status' => 4,
                'message' => 'NOT FOUND USER ID'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('admin/categories/addCategory');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $slug, string $id)
    {
        $newDataCategory = [];
        $id_category = $id ?? '';
        if(!empty($id_category)){
            $data_category = Category::where('categories.id', $id_category)
                                        ->join('users', 'users.id', '=','categories.user_id')
                                        ->select(
                                                'categories.id',
                                                'categories.name_en', 
                                                'categories.name_vn', 
                                                'categories.slug', 
                                                'users.account_name', 
                                                'categories.status'
                                            )
                                        ->first();
            if(!empty($data_category)) {
                $newDataCategory = $data_category->toArray();
            }
            return view('admin/categories/editCategory', ['newDataCategory'=> $newDataCategory]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id_category = $id;
        $validator = Validator::make($request->all() , [
            'name_en'=>'required',
            'name_vn' => 'required',
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $name_en = $request->name_en ?? '';
            $name_vn = $request->name_vn ?? '';
            $slug = $request->slug ?? '';
            $status = $request->status ?? '';

            if(empty($slug)){
                $slug = $this->checkSlug($slug, $name_en);
            }
            $dataCategory = [
                'name_en' => $name_en,
                'name_vn' => $name_vn,
                'slug' => $slug,
                'status' => $status
            ];

            if(!empty($dataCategory)) {
                $checkCategory = DB::table('categories')->where('id', $id)->exists();
                if($checkCategory){
                    try {
                        $checkUpdate = Category::find($id_category)->update($dataCategory);
                        if($checkUpdate) {
                            $data = [
                                'status' => "0",
                                'message' => 'Update Category was successfully!'
                            ];
                            return response()->json($data);
                        }else{

                            return response()->json([
                                'status' => 1,
                                'message' => 'Update Category was fail!'
                            ]);
                        }
                        
                    } catch (\Throwable $th) {
                        return response([
                            'status' => 2,
                            'message' => 'Update Category was fail!',
                            'errCode' => $th
                        ], 500);
                    }
                }else {
                    return response([
                        [
                            'status' => 1,
                            'message' => 'No product found'
                        ]
                    ], 404);
                }
            }
            return response([
                [
                    'status' => 1,
                    'message' => 'No product found'
                ]
            ], 404);
        }

        // $name_en = $request->name_en ?? '';
        // $name_vn = $request->name_vn ?? '';
        // $slug = $request->slug ?? '';
        // $status = $request->status ?? '';

        // if(empty($slug)){
        //     $slug = $this->checkSlug($slug, $name_en);
        // }
        // $dataCategory = [
        //     'name_en' => $name_en,
        //     'name_vn' => $name_vn,
        //     'slug' => $slug,
        //     'status' => $status
        // ];
        // if(!empty($dataCategory)) {
        //     $checkCategory = DB::table('categories')->where('id', $id)->exists();
        //     if($checkCategory){
        //         Category::find($id_category)->update($dataCategory);
        //         return redirect(route('admin.category'))->withSuccess('Update Category was successfully!');
        //     }else {
        //         return redirect(route('admin.category'))->withSuccess('Update Category was failed!');
        //     }
        // }
        // return back()->withSuccess('Update Category was failed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category_delete_id = $request->id ?? ' ';
        $category = Category::find($category_delete_id);
        if($category){
            try {
                $category->delete();
                $data = [
                    'status' => 0,
                    'message' => 'Delete User is Successfully!'
                ];
                return response($data, 201);
            } catch (\Throwable $th) {
                $data = [
                    'status' => 0,
                    'message' => 'Delete User is fail!',
                    'errCode' => $th
                ];
                return response($data, 403);
            };
        }
        $data = [
            'status' => 0,
            'message' => 'not found is user'
        ];
        return response($data, 404);
    }

    public function checkSlug(string $slug, string $name_category){
        if(empty($slug)){
            $slug = $name_category;
        }
        return $slug;
    }
    public function createSlug(string $string){
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
        return $string;
    }
}
