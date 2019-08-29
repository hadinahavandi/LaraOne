<?php

namespace App\Http\Requests\trapp;

use App\Http\Requests\sweetRequest;

class trapp_areatypeAddRequest extends trapp_areatypeUpdateRequest
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

            'name.required' => 'وارد کردن نام اجباری می باشد',
        ];
    }
}