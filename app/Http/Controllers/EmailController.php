<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\ConcatEmail;
use App\Mail\recruitmentMail;
use App\Models\ContentMail;
use App\Models\contentMailRecruitment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
            $fullName = $request->fullname ?? '';
            $phonenumber = $request->phonenumber ?? '';
            $email = $request->email ?? '';
            $content = $request->content ?? '';

            $heading = 'Contact_'.$email;
            $title = $fullName.' + '.$phonenumber;


            $objectMail = new ContentMail($heading, $title, $content);


            $details['email'] = 'contact@ncsoft.tech';

            try {
                $mailContact = new ConcatEmail($objectMail);
                Mail::to($details['email'])->send($mailContact);
                return response([
                    'status' => '0',
                    'message' => 'sendMail is successfully'
                ], 200);
            } catch (\Throwable $th) {
                return response([
                    'status' => '3',
                    'message' => 'sendMail is fail'
                ],403);
            }
    }

    public function sendMailRecruitment (Request $request) {

        $validator = Validator::make($request->all() , [
            'heading' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phonenumber' => 'required',
            'fileMail' => 'required|mimes:jpeg,png,doc,docs,pdf|max:2048',
        ]);

        if(!$validator->passes()) {
            return response()->json([
                'status' => 3,
                'error' => $validator->errors()->toArray()
            ]);
        }else {
            $heading = $request->heading ?? '';
            $name = $request->name ?? '';
            $email = $request->email ?? '';
            $phonenumber = $request->phonenumber ?? '';
            $description = $request->description ?? '';
            $gender = $request->gender == '1' ? 'Nam' :'Nữ';
            $file = $request->file('fileMail') ?? '';
            $nameImage = $this->upload($request->file('fileMail'));
            $mailContact = new contentMailRecruitment($heading, $name, $phonenumber, $gender, $description, $nameImage);
            $details['email'] = 'contact@ncsoft.tech';

            try {
                $mailContact = new recruitmentMail($mailContact);
                Mail::to($details['email'])
                ->send($mailContact);
                $this->removeFileUpload($nameImage);
                return response([
                    'status' => '0',
                    'message' => 'sendMail is successfully'
                ], 200);
                // return back()->withSuccess('sendMail is successfully');
            } catch (\Throwable $th) {
                return response([
                    'status' => '3',
                    'message' => 'sendMail is fail'
                ],403);
        }
        }


    }

    public function upload($file) {
        if ($file) {
            try {
                $originName = $file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $file->storeAs('public/sendFileMail',$fileName);
                return $fileName;
            } catch (\Throwable $th) {
                return '';
            }


        }
    }

    public function removeFileUpload ($file) {
        if (file_exists(storage_path('app/public/sendFileMail/'.$file)))
        {

            @unlink(storage_path('app/public/sendFileMail/'.$file));

        }
    }
}
