<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\News;
use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newDataContext = [];
        $newDataProvide = [];

        $dataNew  = $this->getNewsData() ?? [];
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';
        $title = 'title_'.$language. ' as title';
        $button = 'button_'.$language. ' as button';
        $description = 'description_'.$language.' as description';

        $getAllPage = Page::select(
                                    $heading,
                                    $title,
                                    $button,
                                    $description,
                                    'image',
                                    'page_keyword',
                                    'icon'
                                )
                                ->where('status', 0)
                                ->get();
        $dataContext = [];
        $dataIntroduction = [];
        $dataProvide = [];
        $dataFillContent = [];
        $dataProgramming = [];
        $dataImprove = [];
        $dataActuallyDo = [];
        $dataExperience = [];
        $dataConsultation = [];
        $inprove_info_home = [];

        if(!empty($getAllPage)) {
            foreach($getAllPage as $pageItem) {

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'introduction_home') {
                    array_push($dataIntroduction, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'context_home') {
                    
                    array_push($dataContext, $pageItem);
                }
                
                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'provide_home') {

                    array_push($dataProvide, $pageItem);
                }
                
                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'fill_content_home') {
                    array_push($dataFillContent, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'programming_language_home') {
                    array_push($dataProgramming, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'inprove_content_home') {
                    array_push($dataImprove, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'inprove_info_home') {
                    array_push($inprove_info_home, $pageItem);
                }

                

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'actually_do_home') {
                    array_push($dataActuallyDo, $pageItem);
                }
                
                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'experience_home') {
                    array_push($dataExperience, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'consultation_home') {
                    array_push($dataConsultation, $pageItem);
                }
            }
        }
                
        return view('pages/home', ['dataNew' => $dataNew, 
                        'dataIntroduction' => $dataIntroduction ? $dataIntroduction[0] : [], 
                        'dataContext' => $dataContext, 
                        'dataProvide' =>  $dataProvide,
                        'dataFillContent' => $dataFillContent,
                        'dataProgramming' => $dataProgramming,
                        'dataImprove' => $dataImprove,
                        'dataActuallyDo' => $dataActuallyDo ? $dataActuallyDo[0] : [],
                        'dataExperience' => $dataExperience,
                        'dataConsultation' => $dataConsultation ? $dataConsultation[0] : [],
                        'inprove_info_home' => $inprove_info_home ? $inprove_info_home[0] : []
                    ]);
    }

    public function getNewsData () {
        $timeCurrent = date('Y/m/d');
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';
        $dataNews = News::where('time_display','<=',$timeCurrent)
                    ->select('id',$heading,'image', 'slug')
                    ->orderBy('time_display', 'desc')
                    ->limit(3)
                    ->get()
                    ->toArray();
        return $dataNews;
    }
    
    public function changeLanguage(Request $request) {
        $lang = $request->language;
        $language = config('app.locale');
        if ($lang == 'en') {
            $language = 'en';
        }
        if ($lang == 'vn') {
            $language = 'vn';
        }
        Session::put('language', $language);
        return redirect()->back();
    }
}
