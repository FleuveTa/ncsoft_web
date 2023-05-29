<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index () {
        $timeCurrent = date('Y/m/d');
        $limit = 5;
        $dataNews = [];
        
        $language = Helper::getLocalization() ?? 'vn';
        $title = 'title_'.$language.' as title' ;
        $heading = 'heading_'.$language. ' as heading';
        
        $dataNews = News::where('time_display','<=',$timeCurrent)
            ->select(
                'id',
                $heading,
                'slug',
                $title,
                'image',
                'time_display'
            )->paginate($limit)
             ->toArray();

            $language = Helper::getLocalization() ?? 'vn';
            $heading = 'heading_'.$language. ' as heading';
            $bannerPage = Page::where('page_keyword', 'banner_news')
            ->select($heading,'image')
            ->first();
        return view('pages/news', ['dataNews' => $dataNews, 'bannerPage' => $bannerPage]);
    }
    public function getOrtherNews($id, $language){
        $dataNews = [];
        $timeCurrent = date('Y/m/d');
        $title = 'title_'.$language.' as title' ;
        $heading = 'heading_'.$language. ' as heading';
        if(!empty($id)){
            $dataNews = News::where('id','<>', $id)
                        ->where('time_display','<=',$timeCurrent)
                    ->select(
                        'id',
                        $heading ,
                        $title,
                        'time_display',
                        'image',
                        'slug'
                    )->orderBy('time_display','DESC')
                    ->limit(8)
                    ->get()
                    ->toArray();
           
        }
        return $dataNews;
    }

    public function showDetail (string $id) {
        $language = true;
        $onlyDataNew = [];
        $dataOrtheNews = [];
        $language = Helper::getLocalization() ?? 'vn';
        $title = 'title_'.$language.' as title' ;
        $heading = 'heading_'.$language. ' as heading';


        $description = 'description_'.$language. ' as description';
            $onlyDataNew =  News::where('id', $id)
                ->select(
                    $heading,
                    $title,
                    $description,
                    'image'
                )
                ->get()
                ->first()
                ->toArray();
            
        
        $dataOrtheNews = $this->getOrtherNews($id, $language);
        return view('pages/detailNews', ['onlyDataNew' => $onlyDataNew, 'dataOrtheNews'=>$dataOrtheNews]);
    }
}
