<?php
namespace App\Http\Requests\carserviceorder;
use App\Http\Requests\sweetRequest;
class carserviceorder_carmakerAddRequest extends carserviceorder_carmakerUpdateRequest
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
            'logoigu.required' => 'وارد کردن لوگو اجباری می باشد',
        ];
    }
}