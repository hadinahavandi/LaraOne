<?php

namespace App\Http\Requests\trapp;

use App\Http\Requests\sweetRequest;

class trapp_villaownerUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [


            'name' => 'required',
            'nationalcodebnum' => 'required|numeric|digits:10',
            'address' => 'required',
            'shabacodebnum' => 'required|numeric',
            'telbnum' => 'required|numeric',
            'placemanarea' => 'required|min:-1|integer',
        ];
        return $Fields;
    }

    public function messages()
    {
        return [

            'name.required' => 'وارد کردن نام اجباری می باشد',
            'user.required' => 'وارد کردن کاربر اجباری می باشد',
            'user.integer' => 'مقدار کاربر صحیح وارد نشده است.',
            'nationalcodebnum.required' => 'وارد کردن کد ملی اجباری می باشد',
            'nationalcodebnum.numeric' => 'مقدار کد ملی باید عدد انگلیسی باشد.',
            'nationalcodebnum.digits' => 'کد ملی باید ۱۰ رقمی باشد.',
            'address.required' => 'وارد کردن آدرس اجباری می باشد',
            'shabacodebnum.required' => 'وارد کردن کد شبا اجباری می باشد',
            'shabacodebnum.numeric' => 'مقدار کد شبا باید عدد انگلیسی باشد.',
            'telbnum.required' => 'وارد کردن تلفن اجباری می باشد',
            'telbnum.numeric' => 'مقدار تلفن باید عدد انگلیسی باشد.',
            'backuptelbnum.required' => 'وارد کردن تلفن شماره ۲ اجباری می باشد',
            'backuptelbnum.numeric' => 'مقدار تلفن شماره ۲ باید عدد انگلیسی باشد.',
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'backupmobilebnum.required' => 'وارد کردن تلفن همراه شماره ۲ اجباری می باشد',
            'backupmobilebnum.numeric' => 'مقدار تلفن همراه شماره ۲ باید عدد انگلیسی باشد.',
            'photoigu.required' => 'وارد کردن تصویر اجباری می باشد',
            'nationalcardigu.required' => 'وارد کردن تصویر کارت ملی اجباری می باشد',
            'placemanarea.required' => 'وارد کردن منطقه اجباری می باشد',
            'placemanarea.integer' => 'مقدار منطقه صحیح وارد نشده است.',
        ];
    }
}