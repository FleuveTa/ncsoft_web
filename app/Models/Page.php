<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'heading_vn',
        'heading_en',
        'title_vn',
        'title_en',
        'description_vn',
        'description_en',
        'user_id',
        'button_vn',
        'button_en',
        'icon',
        'page_keyword',
        'image',
        'status',
        'active'
    ];


    public  function getAllData () {

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
                
                
            }
        }
        return [
            'dataIntroduction' => $dataIntroduction[0], 
            'dataContext' => $dataContext, 
            'dataProvide' =>  $dataProvide,
            'dataFillContent' => $dataFillContent,
            'dataProgramming' => $dataProgramming
        ];
    }

    public function  getDataAbout () {
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';
        $title = 'title_'.$language. ' as title';
        $button = 'button_'.$language. ' as button';
        $description = 'description_'.$language.' as description';

        $dataBanner = [];
        $dataCorporate = [];
        $dataAboutLibrary = [];
        $dataAboutLibrary = [];
        $dataActuallyDo = [];
        $dataTestimonialsAbout = [];
        $datalistContentTesti = [];
        $dataIntroProject = [];
        $dataIntroContent = [];
        $dataFillContent = [];
        $dataConsultation = [];
        
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

                    if(!empty($getAllPage)) {
                        foreach($getAllPage as $pageItem) {
            
                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'banner_about') {
                                array_push($dataBanner, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'corporate_about') {
                                array_push($dataCorporate, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'photo_about') {
                                array_push($dataAboutLibrary, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'actually_do_about') {
                                array_push($dataActuallyDo, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'testimonials_about') {
                                array_push($dataTestimonialsAbout, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'list_content_testimonials_about') {
                                array_push($datalistContentTesti, $pageItem);
                            }

                            
                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'intro_project_about') {
                                array_push($dataIntroProject, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'intro_content_about') {
                                array_push($dataIntroContent, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'fill_content_about') {
                                array_push($dataFillContent, $pageItem);
                            }

                            if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'consultation_about') {
                                array_push($dataConsultation, $pageItem);
                            }

                        }
                    }
        

        return [
            'dataBanner' => $dataBanner ? $dataBanner[0] : [],
            'corporate_about' => $dataCorporate ? $dataCorporate[0] : [],
            'dataAboutLibrary' => $dataAboutLibrary ? $dataAboutLibrary : [],
            'dataActuallyDo' => $dataActuallyDo ? $dataActuallyDo[0] : [],
            'dataTestimonialsAbout' => $dataTestimonialsAbout ? $dataTestimonialsAbout[0] : [],
            'datalistContentTesti' => $datalistContentTesti ? $datalistContentTesti : [],
            'dataIntroContent' => $dataIntroContent,
            'dataIntroProject' => $dataIntroProject ? $dataIntroProject[0] : [],
            'dataFillContent' => $dataFillContent,
            'dataConsultation' => $dataConsultation ? $dataConsultation[0] : []
        ];
    }


    public function getDataService() {
        $getAllPage = $this->getDataPage();



        $banner_service = [];
        $banner_content_service = [];
        $banner_box_item = [];
        $intro_service = [];
        $content_first_service = [];
        $content_second_service = [];
        $content_third_service = [];

        if(!empty($getAllPage)) {
            foreach($getAllPage as $pageItem) {

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'banner_service') {
                    array_push($banner_service, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'banner_content_service') {
                    array_push($banner_content_service, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'banner_box_item') {
                    array_push($banner_box_item, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'intro_service') {
                    array_push($intro_service, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'content_first_service') {
                    array_push($content_first_service, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'content_second_service') {
                    array_push($content_second_service, $pageItem);
                }

                if(!empty($pageItem['page_keyword']) && $pageItem['page_keyword'] == 'content_third_service') {
                    array_push($content_third_service, $pageItem);
                }

                


                
            }
        }

        return [
            'banner_service' => $banner_service ? $banner_service[0] : [],
            'banner_content_service' => $banner_content_service ? $banner_content_service[0] : [],
            'banner_box_item' => $banner_box_item ? $banner_box_item : [],
            'intro_service' => $intro_service ? $intro_service[0] : [],
            'content_first_service' => $content_first_service ? $content_first_service[0] : [],
            'content_second_service' => $content_second_service ? $content_second_service[0] : [],
            'content_third_service' => $content_third_service ? $content_third_service[0] : [],
        ];
    }

    public function getDataPage () {
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
            return $getAllPage;
    }
}
