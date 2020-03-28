<?php

namespace App\Http\Requests\placeman;

use App\Http\Requests\sweetRequest;

class placeman_cityAddRequest extends placeman_cityUpdateRequest
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
            'provinceid.required' => 'وارد کردن استان اجباری می باشد',
            'provinceid.integer' => 'مقدار استان صحیح وارد نشده است.',
        ];
    }
}