<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LanguageContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ContentLanguageController extends Controller
{
    public function index () {

         return view('admin/LanguageContext/managerLanguage');

    }

    public function getData () {
        $dataLang = LanguageContext::join('users', 'users.id', '=', 'language_contexts.user_id')
                                ->select(
                                    'language_contexts.id',
                                    'language_contexts.keyword',
                                    'language_contexts.content_vn',
                                    'language_contexts.content_en',
                                    'users.account_name'
                                )
                                ->get();
        return DataTables::of($dataLang)
            ->editColumn('content_vn', function ($lang) {
                return '<div class="three-line-paragraph">'.$lang['content_vn'].'</div>';
            })
            ->editColumn('content_en', function ($lang) {
                return '<div class="three-line-paragraph">'.$lang['content_en'].'</div>';
            })
            ->addColumn('action', function ($lang) {
                $html = '<td>'.
                        '<div class="dropdown">'.
                                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Action'.
                                '</button>'.
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                                    '<a '.
                                        'class="dropdown-item" '.
                                        'href="'.route('admin.contentLanguageEdit', ['id'=>$lang->id ?? ' ']).'"'.
                                    '>'.
                                        'Edit'.
                                    '</a>'.
                                    '<button '.
                                        'class="dropdown-item btn__deleteLang"'.
                                        'value = "'.$lang->id.'"'.
                                    '>'.
                                    'Delete'.
                                    '</button>'.
                                '</div>'.
                            '</div>'.
                        '</td>';
                return $html;
            })
            ->rawColumns([ 'action', 'content_en', 'content_vn'])
            ->make(true);
    }
    public function showAddContextLanguage(){
        return view('admin/LanguageContext/addLanguage');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'keyword' => 'required',
            'content_vn' => 'required',
            'content_en' => 'required'
        ]);


        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $keyword = $request->keyword ?? '';
            $contentVn  = $request->content_vn ?? '';
            $contentEn  = $request->content_en ?? '';
            $checkKeyword = $this->checkKeyword($keyword);
            $user_id = $request->user_id ?? '';
            if(!$checkKeyword){
                try {
                    LanguageContext::create([
                        'keyword' => $keyword,
                        'content_vn' => $contentVn,
                        'content_en' => $contentEn,
                        'user_id' => $user_id
                    ]);
                    return response([
                        'status' => 0,
                        'message' => 'Create new Content Language is successfully'
                    ], 200);

                } catch (\Throwable $th) {
                    return response([
                        'status' => 3,
                        'message' => 'Create new Content Language is fail'
                    ], 405);
                }
            }else {
                return response([
                    'status' => 4,
                    'message' => 'Keyword context Lang is exist'
                ], 403);
            }
        }
    }

    
    public function checkKeyword($keyword){
        $check = LanguageContext::where('keyword', '=', $keyword)->get()->Count();
        if($check > 0 ){
            return true;
        }
        return false;
        
    }

    public function getAllContentLanguage(){
        $data = LanguageContext::join('users', 'users.id', '=', 'language_contexts.user_id')
                                ->select(
                                    'language_contexts.id',
                                    'language_contexts.keyword',
                                    'language_contexts.content_vn',
                                    'language_contexts.content_en',
                                    'users.account_name'
                                )
                                ->get()
                                ->toArray();
        return $data;
    }
    public function destroy(Request $request)
    {
        $contentLanguage = LanguageContext::find($request->id);
        if($contentLanguage){
            try {
                $contentLanguage->delete();
                return response([
                    'status' => 0,
                    'message' => 'Delete Banner is Successfully'
                ], 200);
            } catch (\Throwable $th) {
                return response([
                    'status' => 3,
                    'message' => 'Delete Banner is fail'
                ],405);
            }
        }
        return response([
            'status' => 4,
            'message' => 'Not Found Context Language ID'
        ],404);
    }

    public function edit(Request $request, string $id) {
        $newDataContentLang = [];
        $id_content_language = $id ?? '';
        if(!empty($id_content_language)) {
            $data_content_language = LanguageContext::where('language_contexts.id', $id_content_language)
                                    ->join('users', 'users.id', '=', 'language_contexts.user_id')
                                    ->select(
                                        'language_contexts.id',
                                        'language_contexts.keyword',
                                        'language_contexts.content_vn',
                                        'language_contexts.content_en',
                                        'users.account_name',
                                    )->first();
            if(!empty($data_content_language)) {
                $newDataContentLang = $data_content_language->toArray();
            }
            return view('admin/LanguageContext/editContentLanguage', ['newDataContentLang'=> $newDataContentLang]);
        }
    }

    public function update(Request $request, string $id) {
        $id_category = $id;
        $validator = Validator::make($request->all() , [
            'keyword' => 'required',
            'content_vn' => 'required',
            'content_en' => 'required'
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {

            $data = [
                'content_vn' => $request->content_vn ?? '',
                'content_en' => $request->content_en ?? ''
            ];
    
            if(!empty($data)){
                try {
                    $check = LanguageContext::where('id',$id)->update($data);
                    if ( $check ) {
                        return response([
                            'status' => 0,
                            'message' => 'Update Content Language is Successfully'
                        ],200);
                    }
                    return response([
                        'status' => 1,
                        'message' => 'Update Content Language is fail'
                    ],403);
    
                } catch (\Throwable $th) {
                    return response([
                        'status' => 3,
                        'message' => 'Update Content Language is fail'
                    ],403);
                }
                return response([
                    'status' => 4,
                    'message' => 'Error'
                ],403);
    
            }
        }
    }

    public function save() {
        try {
            $dataContentVn = $this->getContent('vn');
            $dataContentEn = $this->getContent('en');
            Storage::disk('getFileLang')->put('en.json', json_encode($dataContentEn));
            Storage::disk('getFileLang')->put('vn.json', json_encode($dataContentVn));
            return back()->withSuccess('save data Content Language is Successfully');
        } catch(\Throwable $th) {
            return back()->withError('save data Content Language is fail');
        }
    }

    public function getContent($string) {
        $content = 'content_'.$string.' as content';
        $dataContent = LanguageContext::select('keyword',$content)->get()->toArray();
        $newdata = [];
        if(!empty($dataContent)){
            foreach($dataContent as $contentItem ) {
                $newdata[$contentItem['keyword']] = $contentItem['content'];
            }
        }
        return $newdata;
    }
}
