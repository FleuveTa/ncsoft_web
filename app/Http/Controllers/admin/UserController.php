<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionConstant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin/users/managerUser');
    }

    public function getDataUser() {

        $user = User::select('id','account_name','first_name','last_name','email','address','image','status','role')
        ->get();

       return DataTables::of($user)
                ->editColumn('image', function ($user) {
                    $image = $user->image ?? ' ';
                    $url = url('images/users/'.$image);
                    $image = '<img src="'.$url.'" alt="Cover" width="500" height="600">';
                    return $image;
                })
                ->addColumn('action', function ($user) {
                    $html = '<td>'.
                            '<div class="dropdown">'.
                                    '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                        'Action'.
                                    '</button>'.
                                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                        '<a '.
                                            'class="dropdown-item" '.
                                            'href="'.route('admin.getOnlyUser', ['id'=>$user->id]).'"'.
                                        '>'.
                                            'Edit'.
                                        '</a>'.
                                        '<button '.
                                            'class="dropdown-item btn__deleteUser"'.
                                            'value = "'.$user->id.'"'.
                                        '>'.
                                        'Delete'.
                                        '</button>'.
                                    '</div>'.
                                '</div>'.
                            '</td>';
                    return $html;
                })
                ->editColumn('role', function ($user) {
                    $role = Role::Role;
                    $roleUser = $user->role;
                        return $role[$roleUser];
                })
                ->rawColumns(['action', 'image'])

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
    public function showAddUser(){
        $role=Role::Role??[];

        return view('admin/users/addUser', ['role'=>$role]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all() , [
            'account_name'=> 'required|max:255',
            'password'=> 'required|min:6',
            'email' => 'required|email|max:255',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role'=> 'required'
        ]);

        if ( !$validator->passes() ) {

            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);

        } else {

            $account_name = $request->account_name ?? '';
            $first_name = $request->first_name ?? '';
            $last_name = $request->last_name ?? '';
            $email = $request->email ?? '';
            $address = $request->address ?? '';
            $password = $request->password  ?? '';
            $status = $request->status ?? '';
            $role = $request->role ?? '';

            if ($request->hasFile('image')) {
                $originName = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                $request->file('image')->move(public_path('images/users'), $fileName);

                // $url = asset('images/' . $fileName);
                // return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);

                $data = [
                    'account_name' => $account_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'address' => $address,
                    'image' => $fileName,
                    'password' => Hash::make($password),
                    'status' => $status,
                    'role' => $role,
                ];

                $checkEmail = $this->checkEmail($email);

                if(!$checkEmail) {
                    try {
                        User::create($data);
                        $data = [
                            'status' => 0,
                            'message' => 'Add New User was successful!',
                        ];
                        return response($data, 201);
                    } catch (\Throwable $th) {
                        $data = [
                            'status' => 3,
                            'message' => 'Add New User was successful!',
                            'errCode' => $th,
                        ];
                        return response($data, 500);
                    }
                }else {
                    $data = [
                        'status' => 1,
                        'message' => 'Email already exists'
                    ];
                    return response($data, 403);
                }
            }



        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $idUser = $request->id;
        if($idUser){
            $checkPermissionUser = DB::table('permissions')->where('user_id', $idUser)->exists();
            if($checkPermissionUser){
                $getdataOnlyUser = DB::table('users')
                                ->join('permissions', 'permissions.user_id','=', 'users.id')
                                ->where('users.id', $idUser)
                                ->select('users.id',
                                    'users.account_name',
                                    'users.first_name',
                                    'users.last_name',
                                    'users.email',
                                    'users.address',
                                    'users.image',
                                    'users.status',
                                    'users.role',
                                    'permissions.permission'
                                )->first();
                if(!empty($getdataOnlyUser)){
                    $dataResponseUser = [
                        'id' => $getdataOnlyUser-> id,
                        'account_name' => $getdataOnlyUser->account_name ?? '',
                        'first_name' => $getdataOnlyUser->first_name ?? '',
                        'last_name' => $getdataOnlyUser->last_name ?? '',
                        'email' => $getdataOnlyUser-> email ?? '',
                        'address' => $getdataOnlyUser-> address ?? '',
                        'image' => $getdataOnlyUser-> image ?? '',
                        'status' => $getdataOnlyUser-> status ?? '',
                        'role' => $getdataOnlyUser-> role ?? '',
                        'permission' => $getdataOnlyUser->permission ? json_decode($getdataOnlyUser->permission) : ''
                    ];


                    $role = Role::Role;

                    $permissionModel = PermissionConstant::Permistion;
                    return view('admin/users/editUser', ['dataOnlyUser' => $dataResponseUser ?? [], 'role'=>$role, 'permissionModel'=> $permissionModel]);
                }
            }else {
                $getdataOnlyUser = DB::table('users')
                                ->where('users.id', $idUser)
                                ->select('users.id',
                                    'users.account_name',
                                    'users.first_name',
                                    'users.last_name',
                                    'users.email',
                                    'users.address',
                                    'users.image',
                                    'users.status',
                                    'users.role',
                                )->first();
                if(!empty($getdataOnlyUser)){
                    $dataResponseUser = [
                        'id' => $getdataOnlyUser-> id,
                        'account_name' => $getdataOnlyUser->account_name ?? '',
                        'first_name' => $getdataOnlyUser->first_name ?? '',
                        'last_name' => $getdataOnlyUser->last_name ?? '',
                        'email' => $getdataOnlyUser-> email ?? '',
                        'address' => $getdataOnlyUser-> address ?? '',
                        'image' => $getdataOnlyUser-> image ?? '',
                        'status' => $getdataOnlyUser-> status ?? '',
                        'role' => $getdataOnlyUser-> role ?? ''
                    ];
                    $role = Role::Role;
                    $permissionModel = PermissionConstant::Permistion;

                    return view('admin/users/editUser', ['dataOnlyUser' => $dataResponseUser ?? [], 'role'=>$role, 'permissionModel'=> $permissionModel]);
                }
            }


            return view('admin/users/editUser', ['dataOnlyUser' => []]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'account_name'=> 'required|max:255',
            'email' => 'required|email|max:255',
            'status' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role'=> 'required'
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $account_name = $request->account_name ?? '';
            $first_name = $request->first_name ?? '';
            $last_name = $request->last_name ?? '';
            $email = $request->email ?? '';
            $address = $request->address ?? '';
            $status = $request->status ?? '';
            $role = $request->role ?? '';
            $permission = $request->permission ?? '';
            $user = DB::table('users')->where('id', $id)->first();
            if($user) {
                if ($request->hasFile('image')) {

                    try {
                        if (file_exists(public_path('images/users/'.$user->image)))
                        {

                            @unlink(public_path('images/users/'.$user->image));

                        }
                        $originName = $request->file('image')->getClientOriginalName();
                        $fileName = pathinfo($originName, PATHINFO_FILENAME);
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileName = $fileName . '_' . time() . '.' . $extension;

                        $request->file('image')->move(public_path('images/users'), $fileName);

                        $data = [
                            'account_name' => $account_name,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'address' => $address,
                            'image' => $fileName,
                            'status' => $status,
                            'role' => $role,
                        ];


                            $check = DB::table('users')->where('id', $id)->update($data);

                            $checkPermission = DB::table('permissions')->where('user_id', $id)->count();
                            if($checkPermission <= 0){
                                Permission::Create([
                                    'user_id'=> $id,
                                    'permission' => json_encode($permission)
                                ]);
                            }else {
                                DB::table('permissions')->where('user_id', $id)->update([
                                    'permission' => json_encode($permission)
                                ]);
                            }
                            return response([
                                'status' => 0,
                                'message' => 'Update User is successfully!!',
                            ]);
                    } catch (\Throwable $th) {

                        return response([
                            'status' => 3,
                            'message' => 'error',
                            'errCode' => $th,
                        ]);
                    }
                }else {
                    try {
                        $data = [
                            'account_name' => $account_name,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'address' => $address,
                            'status' => $status,
                            'role' => $role,
                        ];


                        $check = DB::table('users')->where('id', $id)->update($data);

                        $checkPermission = DB::table('permissions')->where('user_id', $id)->count();
                        if($checkPermission <= 0){
                            Permission::Create([
                                'user_id'=> $id,
                                'permission' => json_encode($permission)
                            ]);
                        }else {
                            DB::table('permissions')->where('user_id', $id)->update([
                                'permission' => json_encode($permission)
                            ]);
                        }
                        return response([
                            'status' => 0,
                            'message' => 'Update User is successfully!!',
                        ]);
                    } catch (\Throwable $th) {

                        return response([
                            'status' => 3,
                            'message' => 'error',
                            'errCode' => $th,
                        ]);
                    }


                }

            }


        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $userId = $request->id ?? '';
        $user = User::find($userId);
        if($user){
            try {

                $user->delete();



                $data = [
                    'status' => 0,
                    'message' => 'Delete User is Successfully',
                ];

                return response($data, 201);

                // Session::flash('deleteUser', 'Delete User is Successfully');
                // return back();

            } catch (\Throwable $th) {
                $data = [
                    'status' => 1,
                    'message' => 'Delete User is fail',
                    'errCode' =>$th
                ];
                return response($data, 401);
            }
        }else{
            $data = [
                'status' => 2,
                'message' => 'not found this user',
            ];
            return response($data, 404);
        }
    }


    // Trash
    public function getDataTrash () {
        $getDataTrash = User::onlyTrashed()->get() ?? [];
        return DataTables::of($getDataTrash)
                ->addColumn('action', function ($dataTrash) {
                    $html = '';
                    $permission = Helper::handlePermission();
                    if(Gate::check('update', $permission)) {
                        if(Gate::check('delete', $permission)) {
                            $html = '<td>'.
                                '<div class="dropdown">'.
                                        '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                            'Action'.
                                        '</button>'.
                                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                            '<button '.
                                                'class="dropdown-item btn__restoreUser" '.
                                                'value = "'.$dataTrash->id.'"'.
                                            '>'.
                                                'Restore'.
                                            '</button>'.
                                            '<button '.
                                                'class="dropdown-item btn__deleteUserTrash"'.
                                                'value = "'.$dataTrash->id.'"'.
                                            '>'.
                                            'Delete'.
                                            '</button>'.
                                        '</div>'.
                                    '</div>'.
                                '</td>';
                        }
                        $html = '<td>'.
                                '<div class="dropdown">'.
                                        '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                            'Action'.
                                        '</button>'.
                                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                            '<button '.
                                                'class="dropdown-item btn__restoreUser" '.
                                                'value = "'.$dataTrash->id.'"'.
                                            '>'.
                                                'Restore'.
                                            '</button>'.
                                            '<button '.
                                                'class="dropdown-item btn__deleteUserTrash"'.
                                                'value = "'.$dataTrash->id.'"'.
                                            '>'.
                                            'Delete'.
                                            '</button>'.
                                        '</div>'.
                                    '</div>'.
                                '</td>';
                    }

                    return $html;
                })
                ->editColumn('role', function ($dataTrash) {
                    $role = Role::Role;
                    $roleUser = $dataTrash->role;
                        return $role[$roleUser];
                })
                ->rawColumns(['action'])

                ->make(true);
    }
    public function showTrash () {
        return view('admin/users/trashUsers');
    }

    public function restoreTrash (Request $request) {
        $recruitment_id = $request->id ?? '';

        try {
            $checkTrash = User::withTrashed()
                            ->where('id', $recruitment_id)
                            ->restore();
            if($checkTrash) {
                return response([
                    'status' => 0,
                    'message' => 'Restore Item User is Successfully'
                ], 200);
            }
            return response([
                'status' => 1,
                'message' => 'Restore Item user is fail'
            ], 403);

        } catch (\Throwable $th) {
            return response([
                'status' => 3,
                'message' => 'Restore Item Recruitment is fail'
            ], 403);
        }
    }

    public function permanentTrash (Request $request) {
        $recruitment_id = $request->id ?? '';
        $user = User::withTrashed()
                            ->where('id', $recruitment_id)
                            ->get();

        try {
            if($user) {
                $dataUser = $user[0];
                if (file_exists(public_path('images/users/'.$dataUser->image)))
                {

                    @unlink(public_path('images/users/'.$dataUser->image));

                }

            $checkTrash = $dataUser->forceDelete();
            if($checkTrash) {
                return response([
                    'status' => 0,
                    'message' => 'Delete permanent Item user is Successfully'
                ], 200);

            }
            }


        } catch (\Throwable $th) {
            return response([
                'status' => 3,
                'message' => 'Delete permanent Item user is fail'
            ], 403);
        }
    }
    // end Trash
    public function checkEmail($email){
        $checkEmail = DB::table('users')->where('email', $email)->count();
        if($checkEmail > 0){
            return true;
        }
        return false;
    }
}
