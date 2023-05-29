<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageConstant extends Model
{
    use HasFactory;
    const Pages = [
        'introduction_home',
        'context_home',
        'provide_home',
        'inprove_info_home',
        'inprove_content_home',
        'programming_language_home',
        'fill_content_home',
        'actually_do_home',
        'experience_home',
        'consultation_home',
        'banner_recruitment',
        'banner_news',
        'banner_contact',
        'banner_about',
        'corporate_about',
        'photo_about',
        'actually_do_about',
        'testimonials_about',
        'list_content_testimonials_about',
        'intro_project_about',
        'intro_content_about',
        'fill_content_about',
        'consultation_about',
        'banner_service',
        'banner_content_service',
        'banner_box_item',
        'intro_service',
        'content_first_service',
        'content_second_service',
        'content_third_service'
    ];
}
