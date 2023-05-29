<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_font',
        'name_font',
        'font_value',
        'font_family',
        'active',
        'user_id'
    ];

    const font = [
        'roboto'=>'Roboto',
        'open_sans' => 'Open Sans',
        'montserrat' => 'Montserrat',
        'wix_mandefor_display' => 'Wix Nabdefor Text'
    ];


    public function checkExists($name) {
        if(!empty($name)) {
            $check = Font::where('name_font', '=', $name)->exists();
            if($check) {
                return true;
            }else {
                return false;
            }
        }
        return false;
    }
    

    public function checkKeyFormExist($key) {
        $check = Font::where('key_font', $key)->exists();

        if ( $check ) {
            return true;
        }

        return false;
    }

    public function createOne($data) {
        try {
            $create = Font::create($data);
            if($create) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            dd($th);
        }
        
    }

    public function createKeyFont(string $string){
        if(!empty($string)){
            $search = array(
                '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
                '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
                '#(ì|í|ị|ỉ|ĩ)#',
                '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
                '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
                '#(ỳ|ý|ỵ|ỷ|ỹ)#',
                '#(đ)#',
                '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
                '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
                '#(Ì|Í|Ị|Ỉ|Ĩ)#',
                '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
                '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
                '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
                '#(Đ)#',
                "/[^a-zA-Z0-9\-\_]/",
            );
            $replace = array(
                'a',
                'e',
                'i',
                'o',
                'u',
                'y',
                'd',
                'A',
                'E',
                'I',
                'O',
                'U',
                'Y',
                'D',
                '-',
            );
            $string = preg_replace($search, $replace, $string);
            $string = preg_replace('/(-)+/', '_', $string);
            $string = strtolower($string);
        }
        return $string ?? '';
    }

    public function getAllKey() {
        $data = Font::select('key_font', 'name_font')->get();

        return $data ? $data->toArray() : [];
    }

    public function changeAllActive($key) {

        $checkKey = $this->checkKeyFormExist($key);
        if($checkKey) {
            $checkUpdate = Font::where('key_font','!=', $key)
                        ->update([
                            'active' => 0
                        ]);
        
            $checkupdateActive = $this->changeActiveOne($key);
            
            if($checkupdateActive) {
                return true;
            }
            return false;
        } 
        return false;
    }

    public function changeActiveOne($key) {
        $check = Font::where('key_font','=', $key)
                        ->update([
                            'active' => 1
                        ]);
        if( $check ) {
            return true;
        }

        return false;
    }

    public function getFontView ()  {
        $data  = Font::where('active',1)
            ->select('name_font', 'font_value', 'font_family')->first();
        
        return $data;
    }
}
