<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/banner/managerBanner');
    }
    //...
    public function getData() {
        $dataBanner = Banner::join('users', 'banners.user_id', '=', 'users.id')
                            ->select('banners.id',
                                'banners.title_vn',
                                'banners.title_en',
                                'banners.description_vn',
                                'banners.description_en',
                                'banners.button_name_vn',
                                'banners.button_name_en',
                                'banners.image',
                                'users.account_name',
                                'banners.order',
                                'banners.status',
                            )->get();
        return DataTables::of($dataBanner)
        ->editColumn('image', function ($banner) {
            $image = $banner->image ?? ' ';
            $url = url('images/banners/'.$image);
            $image = '<img src="'.$url.'" alt="Cover" width="400" height="500">';

            return $image;
        })
        ->editColumn('description_vn', function ($banner) {
            return '<div class="three-line-paragraph-description">'.$banner['description_vn'].'</div>';
        })
        ->editColumn('description_en', function ($banner) {
            return '<div class="three-line-paragraph-description">'.$banner['description_en'].'</div>';
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
        ->addColumn('action', function ($banner) {

            $html  =
            '<div class="dropdown">'.
                    '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                        'Action'.
                    '</button>'.
                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                        '<a '.
                            'class="dropdown-item" '.
                            'href="'.route("admin.bannerEdit", ["id" => $banner['id']]) .'"'.
                        '>'.
                            'Edit'.
                        '</a>'.
                        '<button '.
                            'class="dropdown-item btn__deleteBanner" '.
                            'value = "'.$banner['id'].'"'.
                        '>'.
                            'Delete'.
                        '</button>'.
                    '</div>'.
            '</div>';
                return $html;
        })
        ->rawColumns(['description_vn', 'description_en', 'status', 'action', 'image'])
        ->make(true);
    }

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
            'title_vn'=> 'required|max:255',
            'title_en'=> 'required|max:255',
            'description_vn'=> 'required|max:255',
            'description_en'=> 'required|max:255',
            'button_name_vn'=> 'required|max:255',
            'button_name_en'=> 'required|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order'=> 'required'
        ]);

        if ( !$validator->passes() ) {

            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);

        } else {
                $bannerOrder = Banner::where('order', $request->order)->exists();
                if( !$bannerOrder ) {
                        $title_vn = $request->title_vn ?? '';
                        $title_en = $request->title_en ?? '';
                        $description_vn = $request->description_vn ?? '';
                        $description_en = $request->description_en ?? '';
                        $button_name_vn = $request->button_name_vn ?? '';
                        $button_name_en = $request->button_name_en ?? '';
                        $user_id =  $request->user_id ?? '';
                        $order = $request->order ?? '';
                        $status = $request->status ?? '';
                            try {
                                if ($request->hasFile('image')) {
                                    $originName = $request->file('image')->getClientOriginalName();
                                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                                    $extension = $request->file('image')->getClientOriginalExtension();
                                    $fileName = $fileName . '_' . time() . '.' . $extension;

                                    $request->file('image')->move(public_path('images/banners'), $fileName);
                                $data = [
                                    'title_vn' => $title_vn,
                                    'title_en' => $title_en,
                                    'description_vn' => $description_vn,
                                    'description_en' => $description_en,
                                    'button_name_vn' => $button_name_vn,
                                    'button_name_en' => $button_name_en,
                                    'image' => $fileName,
                                    'user_id' =>  $user_id,
                                    'order' => $order,
                                    'status' => $status,
                                ];
                                $banner = Banner::Create($data);
                                if($banner) {
                                    return response([
                                        'status' => 0,
                                        'message' => 'Add new Banner was succesfully'
                                    ]);
                                }
                                return response([
                                    'status' => 1,
                                    'message' => 'Add new Banner was fail'
                                ]);
                            }
                            } catch (\Throwable $th) {
                                return response([
                                    'status' => 3,
                                    'message' => 'Error data or code',
                                    'errCode' => $th
                                ]);
                            }


                }else {
                    return response([
                        'status' => 2,
                        'message' => 'Order Banner is Exists'
                    ]);
                }

        }

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('admin/banner/addBanner');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $newDataBanner = [];
        $id_banner = $id ?? '';
        if(!empty($id_banner)){
            $data_banner= Banner::where('banners.id', $id_banner)
                                        ->join('users', 'users.id', '=','banners.user_id')
                                        ->select(
                                            'banners.id',
                                            'banners.title_vn',
                                            'banners.title_en',
                                            'banners.description_vn',
                                            'banners.description_en',
                                            'banners.button_name_vn',
                                            'banners.button_name_en',
                                            'banners.image',
                                            'users.account_name',
                                            'banners.order',
                                            'banners.status'
                                            )
                                        ->first();
            if(!empty($data_banner)) {
                $newDataBanner = $data_banner->toArray();
            }
            return view('admin/banner/editBanner', ['newDataBanner'=> $newDataBanner]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id_banner = $id ?? '';

        $validator = Validator::make($request->all() , [
            'title_vn'=> 'required|max:255',
            'title_en'=> 'required|max:255',
            'description_vn'=> 'required|max:255',
            'description_en'=> 'required|max:255',
            'button_name_vn'=> 'required|max:255',
            'button_name_en'=> 'required|max:255',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order'=> 'required'
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
                $checkBannerExist = Banner::where('id', $id_banner)->first();

                if($checkBannerExist){
                    if ($request->hasFile('image')) {
                        try {
                            if (file_exists(public_path('images/banners/'.$checkBannerExist->image)))
                            {

                                @unlink(public_path('images/banners/'.$checkBannerExist->image));

                            }

                            $originName = $request->file('image')->getClientOriginalName();
                            $fileName = pathinfo($originName, PATHINFO_FILENAME);
                            $extension = $request->file('image')->getClientOriginalExtension();
                            $fileName = $fileName . '_' . time() . '.' . $extension;

                            $request->file('image')->move(public_path('images/banners'), $fileName);
                            $dataUpdate  = [
                                'title_vn' => $request->title_vn ?? '',
                                'title_en' => $request->title_en ?? '',
                                'description_vn' => $request->description_vn ?? '',
                                'description_en' => $request->description_en ?? '',
                                'button_name_vn' => $request->button_name_vn ?? '',
                                'button_name_en' => $request->button_name_en ?? '',
                                'image' => $fileName,
                                'order' => $request->order ?? '',
                                'status' => $request->status ?? '',
                            ];
                            Banner::find($id_banner)->update($dataUpdate);

                            return response([
                                'status' => 0,
                                'message' => 'update banner is successfully'
                            ],200);

                        } catch (\Throwable $th) {

                            return response([
                                'status' => 3,
                                'message' => 'update banner is fail'
                            ], 403);

                        }

                    }else {
                        try {

                            $dataUpdate  = [
                                'title_vn' => $request->title_vn ?? '',
                                'title_en' => $request->title_en ?? '',
                                'description_vn' => $request->description_vn ?? '',
                                'description_en' => $request->description_en ?? '',
                                'button_name_vn' => $request->button_name_vn ?? '',
                                'button_name_en' => $request->button_name_en ?? '',
                                'order' => $request->order ?? '',
                                'status' => $request->status ?? '',
                            ];
                            Banner::find($id_banner)->update($dataUpdate);

                            return response([
                                'status' => 0,
                                'message' => 'update banner is successfully'
                            ],200);

                        } catch (\Throwable $th) {

                            return response([
                                'status' => 3,
                                'message' => 'update banner is fail'
                            ], 403);

                        }
                    }

                }else{
                    return response([
                        'status' => 3,
                        'message' => 'Banner is exist'
                    ], 404);
                }
            }
            return response([
                'status' => 4,
                'message' => 'No data update'
            ], 403);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $banner = Banner::find($request->id);
        if($banner){
            try {
                $banner->delete();
                return response([
                    'status' => 0,
                    'message' => 'Delete Banner is Successfully'
                ],200);
            } catch (\Throwable $th) {
                return response([
                    'status' => 3,
                    'message' => 'Delete Banner is fail'
                ],403);
            }
        }
        return response([
            'status' => 4,
            'message' => 'Banner id not found'
        ],403);
    }
    public function getAllBanner(){
        $dataBanner = Banner::join('users', 'banners.user_id', '=', 'users.id')
                            ->select('banners.id',
                                'banners.title_vn',
                                'banners.title_en',
                                'banners.description_vn',
                                'banners.description_en',
                                'banners.button_name_vn',
                                'banners.button_name_en',
                                'banners.image',
                                'users.account_name',
                                'banners.order',
                                'banners.status',
                            )->get()
                            ->toArray();
        return $dataBanner;
    }
}
