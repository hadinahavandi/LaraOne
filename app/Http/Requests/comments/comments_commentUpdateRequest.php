<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;

class comments_commentUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'text' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'text.required' => 'وارد کردن متن اجباری می باشد',
        ];
    }
}