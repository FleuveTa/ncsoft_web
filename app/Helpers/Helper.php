<?php 
    namespace App\Helpers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Font;
use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

    class Helper {

        // get Data Category return view
        public static function getCategoryHeader () {
            $language = Helper::getLocalization();
            $name = 'name_'.$language.' as name' ;

            $category = Category::where('Status',0)
                                ->select($name,'slug')
                                ->get()
                                ->toArray();

            return $category;
            
        }

        // get Data Banner return banner
        public static function getDatabanner () {
            $language = 'en';
            $banner = [];
            $language = Helper::getLocalization();
            $title = 'title_'.$language.' as title' ;
            $description = 'description_'.$language. ' as description';
            $button_name = 'button_name_'.$language. ' as button_name';
            $banner = Banner::where('status', 0)
                            ->select(
                                $title, 
                                $description,
                                $button_name,
                                'image'
                                )->orderBy('order')
                                ->get()
                                ->toArray();
            return $banner;
        }

        public static function getDataRecruitment(){
            $timeCurrent  = date('Y/m/d');
            // currentTime and time_display
            $language = true;
            $limit = 5;
            if(true) {
                $dataRecruitment = Recruitment::select(
                    'id',
                    'heading_en as heading',
                    'slug',
                    'description_en as description',
                    'number_of_people',
                    'salary',
                    'timeout',
                    'time_display'
                    )->where('time_display','<=', $timeCurrent)
                    ->paginate($limit)
                    ->toArray();
            }
            return $dataRecruitment;
        }
        
        

        

        public static function getLocalization() {
            if(!empty(session('language'))){
                return session('language');
            }
            return 'vn';
        }

        public static function checkRole(){
            $role = Auth::user()['role'] ?? '';
            
            return $role;
        }

        // check permission
        public static function handlePermission() {
            $idUser = Auth::user()->id;
            if($idUser) {
                $permission = User::find($idUser)->permissions;
            }

            return $permission;
        }


        public static function handlePermissionAdd () {
            $arrPermission = Helper::handlePermission();

            

            // return in_array(0,$arrPermission);
        }

        public static function getColor () {
            $data = file_get_contents(base_path('color/color.json'));

            return $data ? json_decode($data) : '' ;
        }


        public static function getFont() {
            $font = new Font();
            
            $dataFont = $font->getFontView();

            return $dataFont;
        }
        
    }

?>