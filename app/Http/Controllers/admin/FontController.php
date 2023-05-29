<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Font;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FontController extends Controller
{
    public function index () {

        
        $font = new Font();
        
        $listfont  = $font->getAllKey();

        return view('admin/managerFont/managerFont', ['listFont' => $listfont]);
    }

    public function create () {
        return view('admin/managerFont/addFont');
    }


    
    public function update (Request $request) {
        $font = new Font();
        $keyFont = $request->font ?? '';
        $check = $font->changeAllActive($keyFont);
        if($check) {
            return response([
                'status' => 0,
                'message' => 'Change font is successfully'
            ]);
        }
        return response([
            'status' => 1,
            'message' => 'Change font is fail'
        ]);
    }

    public function store(Request $request) {
        $font = new Font();
        $validator = Validator::make($request->all() , [
            'name_font'=>'required',
            'font_value' => 'required',
            'font_family' => 'required'
        ]);


        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $font_value="";
            if(!empty($request->font_value)) {
                $font_value = json_encode($request->font_value);
            }
            $key_font = $request->key_font ?? '';
            $name_font = $request->name_font ?? '';
            $font_value = $request->font_value ?? '';
            $font_family = $request->font_family ?? '';
            $user_id = $request->user_id ?? '';
            $active = 0;

            if(!empty($key_font)){
                $key_font = $font->createKeyFont($key_font);
            }else {
                $key_font = $font->createKeyFont($name_font);
            }

            if( $font->checkKeyFormExist($key_font) ) {
                return response([
                    'status' => 2,
                    'message' => 'Key font is exists'
                ]);
            }else {
                $data = [
                    'key_font' => $key_font,
                    'name_font' => $name_font,
                    'font_value' => $font_value,
                    'font_family' => $font_family,
                    'active' => $active,
                    'user_id' => $user_id
                ];


                $checkCreate = $font->createOne($data);

                if($checkCreate) {
                    return response([
                        'status' => 0,
                        'message' => 'create font is successfully'
                    ], 200);
                }


                return response([
                    'status' => 1,
                    'message' => 'create font is fail'
                ]);
            }
        }
    }

    

}
