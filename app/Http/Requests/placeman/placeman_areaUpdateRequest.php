<?php

namespace App\Http\Requests\placeman;

use App\Http\Requests\sweetRequest;

class placeman_areaUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [

            'title' => 'required',
            'city' => 'required|min:-1|integer',
        ];
        return $Fields;
    }

    public function messages()
    {
        return [

            'title.required' => 'وارد کردن عنوان اجباری می باشد',
            'city.required' => 'وارد کردن شهر اجباری می باشد',
            'city.integer' => 'مقدار شهر صحیح وارد نشده است.',
        ];
    }
}