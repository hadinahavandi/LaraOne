<?php

namespace App\Http\Requests\common;

use App\Http\Requests\sweetRequest;

class common_dateUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [

            'daydate' => 'required',
            'factordbl' => 'required|numeric',
        ];
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