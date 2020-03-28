<?php

namespace App\Http\Requests\trapp;

use App\Http\Requests\sweetRequest;

class trapp_villaownerAddRequest extends trapp_villaownerUpdateRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [
            'photoigu' => 'required|max:2047',
            'nationalcardigu' => 'required|max:2047',
        ];

        $Fields = array_merge($Fields, parent::rules());
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
            'photoigu.max' => 'حجم تصویر باید کمتر از ۲ مگابایت باشد',
            'nationalcardigu.required' => 'وارد کردن تصویر کارت ملی اجباری می باشد',
            'nationalcardigu.max' => 'حجم تصویر کارت ملی باید کمتر از ۲ مگابایت باشد',
            'placemanarea.required' => 'وارد کردن منطقه اجباری می باشد',
            'placemanarea.integer' => 'مقدار منطقه صحیح وارد نشده است.',
        ];
    }
}