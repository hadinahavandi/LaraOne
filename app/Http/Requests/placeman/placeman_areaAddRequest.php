<?php

namespace App\Http\Requests\placeman;

use App\Http\Requests\sweetRequest;

class placeman_areaAddRequest extends placeman_areaUpdateRequest
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
            'city.required' => 'وارد کردن شهر اجباری می باشد',
            'city.integer' => 'مقدار شهر صحیح وارد نشده است.',
        ];
    }
}