<?php

namespace App\Http\Requests\common;

use App\Http\Requests\sweetRequest;

class common_dateAddRequest extends common_dateUpdateRequest
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

            'day_date.required' => 'وارد کردن day_date اجباری می باشد',
            'factor_dbl.required' => 'وارد کردن factor_dbl اجباری می باشد',
            'factor_dbl.numeric' => 'مقدار factor_dbl باید عدد انگلیسی باشد.',
        ];
    }
}