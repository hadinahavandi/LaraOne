<?php
namespace App\Http\Requests\appman;
use App\Http\Requests\sweetRequest;

class appman_apperrorUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
//            'appname' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
//            'appname.required' => 'وارد کردن نام برنامه اجباری می باشد',
        ];
    }
}