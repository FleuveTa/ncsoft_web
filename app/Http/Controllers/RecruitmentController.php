<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Page;
use App\Models\Recruitment;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index () {
        $timeCurrent  = date('Y/m/d');
        // currentTime and time_display
        $limit = 5;
        $dataRecruitments = [];
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';

        $dataRecruitments = Recruitment::select(
                'id',
                $heading,
                'slug',
                'number_of_people',
                'salary',
                'timeout',
                'time_display'
                )->where('time_display','<=', $timeCurrent)
                ->paginate($limit)
                ->toArray();

            $language = Helper::getLocalization() ?? 'vn';
            $heading = 'heading_'.$language. ' as heading';
            $bannerPage = Page::where('page_keyword', 'banner_recruitment')
            ->select($heading,'image')
            ->first();
        return view('pages/recruitment', ['dataRecruitments' => $dataRecruitments, 'bannerPage' => $bannerPage]);
    }

    public function show () {
        $timeCurrent  = date('Y/m/d');
        // currentTime and time_display
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';

        $limit = 5;
        $dataRecruitments = [];

        $dataRecruitments = Recruitment::select(
                'id',
                $heading,
                'slug',
                'number_of_people',
                'salary',
                'timeout',
                'time_display'
                )->where('time_display','<=', $timeCurrent)
                ->paginate($limit)
                ->toArray();

        return view('pages/recruitment', ['dataRecruitments' => $dataRecruitments]);
    }

    public function showDetail (Request $request, string $id) {
        $language = true;
        $dataRecruitmentDetail =[];
        $language = Helper::getLocalization() ?? 'vn';
        $heading = 'heading_'.$language. ' as heading';
        $description = 'description_'.$language. ' as description';
        
        $dataRecruitmentDetail = Recruitment::where('id', $id)
                ->select(
                    'id',
                    $heading,
                    $description,
                    'number_of_people',
                    'salary',
                    'timeout',
                    )->get()
                    ->first()
                    ->toArray();

        return view('pages/detailRecruitment', ['dataRecruitmentDetail' => $dataRecruitmentDetail]);
    }

}
