<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    public function index () {

        $fetchColor = Helper::getColor();

        return view ('admin/color/EditColor', ['fetchColor'=> $fetchColor]);
    }


    public function updateColor (Request $request) {
        $validator = Validator::make($request->all() , [
            'primary_color'=> 'required|max:255',
            'text_primary_color'=> 'required|max:255',
            'text_background_color'=> 'required|max:255',
            'background_color'=> 'required|max:255',
            'border_color' => 'max:255',
        ]);


        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $data = [
                'primary_color' => $request->primary_color ?? '',
                'text_primary_color' => $request->text_primary_color ?? '',
                'text_background_color' => $request->text_background_color ?? '',
                'border_color' => $request->border_color ?? '',
                'background_color' => $request->background_color ?? '',
                'scroll_color' => $request->scroll_color ?? '',
                'sub_text_primary_color' =>$request->sub_text_primary_color ?? '',
                'background_button_color' => $request->background_button_color ?? '',
                'background_hover_color' => $request->background_hover_color ?? '',
                'text_button_color' => $request->text_button_color ?? '',
                'hover_text_button_color' => $request->hover_text_button_color ?? '',
                'icon_color' => $request->icon_color ?? '',
                'icon_background_color' => $request->icon_background_color ?? '',
                'header_background_color' => $request->header_background_color ?? '',
                'header_text_color' => $request->header_text_color ?? '',
                'header_active_color' => $request->header_active_color ?? '',
                'comment_text_color' => $request->comment_text_color ?? '',
                'comment_background_color' => $request->comment_background_color ?? '',
                'slider_color' => $request->slider_color ?? '',
                'box_service_color' => $request->box_service_color ?? '',
            ];
            
            try {
                Storage::disk('fileColor')->put('color.json', json_encode($data));

                return response([
                    'status' => 0,
                    'message' => 'Update Color is Successfully'
                ], 200);
            } catch (\Throwable $th) {
                return response([
                    'status' => 0,
                    'message' => 'Update Color is fail',
                    'errorCode'=> $th
                ], 405);
            }
        }
    }
    
}
