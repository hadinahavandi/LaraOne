<?php

namespace App\Http\Requests\placeman;

use App\Http\Requests\sweetRequest;

class placeman_provinceUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [

            'title' => 'required',
        ];
        return $Fields;
    }

    public function messages()
    {
        return [

            'title.required' => 'وارد کردن عنوان اجباری می باشد',
        ];
    }
}