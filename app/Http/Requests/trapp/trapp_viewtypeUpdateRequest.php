<?php

namespace App\Http\Requests\trapp;

use App\Http\Requests\sweetRequest;

class trapp_viewtypeUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [

            'name' => 'required',
        ];
        return $Fields;
    }

    public function messages()
    {
        return [

            'name.required' => 'وارد کردن نام اجباری می باشد',
        ];
    }
}