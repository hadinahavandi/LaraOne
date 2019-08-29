<?php

namespace App\Http\Requests\placeman;

use App\Http\Requests\sweetRequest;

class placeman_provinceAddRequest extends placeman_provinceUpdateRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [
        ];

        $Fields = array_merge($Fields, parent::rules());
        return $Fields;
    }

    public function messages()
    {
        return [

            'title.required' => 'وارد کردن عنوان اجباری می باشد',
        ];
    }
}