<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\LogRecruitment;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;



class RecruimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/recruitment/managerRecruitment');
    }

    public function getData () {
        $dataRecruitment = Recruitment::join('users', 'users.id', '=', 'recruitments.user_id')
                                    ->select(
                                    'recruitments.id',
                                    'recruitments.heading_vn',
                                    'recruitments.heading_en',
                                    'recruitments.slug',
                                    'recruitments.description_vn',
                                    'recruitments.description_en',
                                    'recruitments.number_of_people',
                                    'recruitments.salary',
                                    'recruitments.timeout',
                                    'users.account_name',
                                    'recruitments.time_display',
                                    )->get();

        return DataTables::of($dataRecruitment)
        ->editColumn('description_vn', function ($recruitment) {
            return '<div class="three-line-paragraph-description">'.$recruitment['description_vn'].'</div>';
        })
        ->editColumn('description_en', function ($recruitment) {
            return '<div class="three-line-paragraph-description">'.$recruitment['description_en'].'</div>';
        })
        ->addColumn('action', function ($recruitment) {
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
                
                }
                $html  = 
                    '<div class="dropdown">'.
                            '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Action'.
                            '</button>'.
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                '<a '.
                                    'class="dropdown-item" '.
                                    'href="'.route("admin.recruitmentEdit", ["id" => $recruitment['id'] ]) .'"'.
                                '>'.
                                    'Edit'.
                                '</a>'.
                            '</div>'.
                    '</div>';
                return $html;

            }
            
        })
        ->rawColumns(['description_vn','description_en','action'])
        ->make(true);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/recruitment/addRecruitment');
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
            'description_vn' => 'required',
            'description_en' => 'required',
            'salary' => 'required',
            'number_of_people' => 'required|numeric',
            'time_display' => 'required'
        ]);

        if ( !$validator->passes() ) {

            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = [
                'heading_vn' => $request->heading_vn ?? '',
                'heading_en' => $request->heading_en ?? '',
                'description_vn' => $request->description_vn ?? '',
                'description_en' => $request->description_en ?? '',
                'number_of_people' => $request->number_of_people ?? '',
                'salary' => $request->salary ?? '',
                'user_id' => $request->user_id ?? '',
                'slug' => $this->createSlug($request->slug) ?? '',
                'timeout' => date('Y/m/d',strtotime($request->timeout)) ?? '',
                'time_display' => date('Y/m/d',strtotime($request->time_display)) ?? ''
                
            ];

            if($data['time_display'] >= date('Y/m/d')) {
                try {
                    Recruitment::create($data);
                    return response([
                        'status' => 0,
                        'message' => 'Add new Recruitment is Successfully'
                    ], 201);
                    // return redirect(route('admin.recruiment'))->withSuccess('Add new Recruitment is Successfully');
                } catch (\Throwable $th) {
                    return response([
                        'status' => 3,
                        'message' => 'Add new Recruitment is fail',
                        'errCode' => $th
                    ], 405);
                }
            }else {
                return response([
                    'status' => 4,
                    'message' => 'Date display is invalid'
                ], 401);
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
    public function edit(string $id)
    {
        $newDataRecruitment = [];
        $id_recruitment = $id ?? '';
        if(!empty($id_recruitment)){
            $data_recruitment = Recruitment::where('recruitments.id', $id_recruitment)
                                        ->join('users', 'users.id', '=','recruitments.user_id')
                                        ->select(
                                            'recruitments.id',
                                            'recruitments.heading_vn',
                                            'recruitments.heading_en',
                                            'recruitments.slug',
                                            'recruitments.description_vn',
                                            'recruitments.description_en',
                                            'recruitments.salary',
                                            'recruitments.number_of_people',
                                            'recruitments.timeout',
                                            'users.account_name',
                                            'recruitments.time_display',
                                            )
                                        ->first();
        
                                        
            if(!empty($data_recruitment)) {
                $newDataRecruitment = $data_recruitment->toArray();
            }
            return view('admin/recruitment/editRecruitment', ['newDataRecruitment'=> $newDataRecruitment]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all() , [
            'heading_vn' => 'required',
            'heading_en' => 'required',
            'slug' => 'required',
            'description_vn' => 'required',
            'description_en' => 'required',
            'salary' => 'required',
            'number_of_people' => 'required|numeric',
            'time_display' => 'required'
        ]);

        if ( !$validator->passes() ) {

            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        } else { 
            $data = [
                'heading_vn' => $request->heading_vn ?? '',
                'heading_en' => $request->heading_en ?? '',
                'description_vn' => $request->description_vn ?? '',
                'description_en' => $request->description_en ?? '',
                'number_of_people' => $request->number_of_people ?? '',
                'salary' => $request->salary ?? '',
                'slug' => $this->createSlug($request->slug) ?? '',
                'timeout' => date('Y/m/d',strtotime($request->timeout)) ?? '',
                'time_display' => date('Y/m/d',strtotime($request->time_display)) ?? ''
            ];
    
            if(!empty($data)){

                try {

                    Recruitment::where('id',$id)->update($data);
                    return response([
                        'status' => 0,
                        'message' => 'Update Recruitment is Successfully'
                    ], 201);

                } catch (\Throwable $th) {

                    return response([
                        'status' => 3,
                        'message' => 'Update Recruitment is fail',
                        'errCode' => $th
                    ], 405);
                    
                }
    
            }

        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $recruitment_id = $request->id ?? '';
        $recruitment = Recruitment::find($recruitment_id);
        if($recruitment){

            try {

                $checkDelete = $recruitment->delete();
                if( $checkDelete && Auth::id() ) {
                    LogRecruitment::create([
                        'user_id' => Auth::id() ?? '',
                        'status_pass' => 'public',
                        'status_future' => 'trash',
                        'recruitment_id' => $recruitment_id ?? ''
                    ]);

                    
                    return response([
                        'status' => 0,
                        'message' => 'Delete Recruitment is Successfully'
                    ], 201);
                    //  return back()->withSuccess('Delete Recruitment is Successfully');
                }

                return response([
                    'status' => 1,
                    'message' => 'Delete Recruitment is fail'
                ], 403);
                // return back()->withError('Delete Recruitment is fail');

            } catch (\Throwable $th) {
                return response([
                    'status' => 1,
                    'message' => 'Delete Recruitment is fail',
                    'errCode' => $th
                ], 500);
                // return back()->withError('Delete Recruitment is fail in Sql');

            }
        }
        // return response([
        //     'status' => 1,
        //     'message' => 'Delete Recruitment is fail'
        // ], 424);
        Session::flash('deleteRecruitment', 'Delete Recruitment was failed');
        return back();
    }

    // Trash
    public function showTrash(Request $request) {
        $getDataTrash = Recruitment::onlyTrashed()->get() ?? [];
        $dataTrash = [];
        if( !empty($getDataTrash) ) {
            $dataTrash = $getDataTrash->toArray();
        }
        return view('admin/recruitment/trashRecruitment', ['dataTrash' => $dataTrash]);
    }

    public function restoreTrash(Request $request) {
        $recruitment_id = $request->recruitment_restore_id ?? '';
        $user_id = $request->user_id ?? '';
        // $dataRep = [
        //     'status' => 1,
        //     'message' => 'Restore Item Recruitment is Successfully'
        // ];

        // return response($dataRep, 200);

        try {
            $checkTrash = Recruitment::withTrashed()
                            ->where('id', $recruitment_id)
                            ->restore();
            if($checkTrash) {
                LogRecruitment::create([
                    'user_id' => $user_id,
                    'status_pass' => 'trash',
                    'status_future' => 'public',
                    'recruitment_id' => $recruitment_id
                ]);

                Session::flash('demo', 'demo');
                return redirect(route('admin.recruiment'))->withSuccess('Restore Item Recruitment is Successfully');
            }
            return back()->withError('Restore Item Recruitment is fail');

        } catch (\Throwable $th) {
            return back()->withError('Restore Item Recruitment is fail');
        }
    }


    public function permanentlyTrash(Request $request) {
        $recruitment_id = $request->recruitment_delete_id ?? '';
        $user_id = $request->user_id ?? '';

        try {
            $checkTrash = Recruitment::withTrashed()
                            ->where('id', $recruitment_id)
                            ->restore();
            if($checkTrash) {
                LogRecruitment::create([
                    'user_id' => $user_id,
                    'status_pass' => 'trash',
                    'status_future' => 'permanent',
                    'recruitment_id' => $recruitment_id
                ]);
                return redirect(route('admin.recruiment'))->withSuccess('Delete permanent Item Recruitment is Successfully');
            }
            return back()->withError('Delete permanent Item Recruitment is fail');

        } catch (\Throwable $th) {
            return back()->withError('Delete permanent Item Recruitment is fail');

        }


    }

    public function getAllRecruitment(){
        $dataRecruitment = Recruitment::join('users', 'users.id', '=', 'recruitments.user_id')
                        ->select(
                            'recruitments.id',
                            'recruitments.heading_vn',
                            'recruitments.heading_en',
                            'recruitments.slug',
                            'recruitments.description_vn',
                            'recruitments.description_en',
                            'recruitments.number_of_people',
                            'recruitments.salary',
                            'recruitments.timeout',
                            'users.account_name',
                            'recruitments.time_display',
                        )->get()
                        ->toArray();
        
        return $dataRecruitment ?? [];
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
