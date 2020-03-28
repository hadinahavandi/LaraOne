<?php
namespace App\Http\Requests\carserviceorder;
use App\Http\Requests\sweetRequest;

class carserviceorder_carmakerUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'title' => 'required',
            'logoigu' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'title.required' => 'وارد کردن عنوان اجباری می باشد',
            'logoigu.required' => 'وارد کردن لوگو اجباری می باشد',
        ];
    }
}