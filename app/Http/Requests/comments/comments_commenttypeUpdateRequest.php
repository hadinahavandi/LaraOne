<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;

class comments_commenttypeUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'title' => 'required',
            'rated' => 'required',
            'uniquecomment' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'title.required' => 'وارد کردن عنوان اجباری می باشد',
            'rated.required' => 'وارد کردن دارای رتبه اجباری می باشد',
            'uniquecomment.required' => 'وارد کردن is_uniquecomment اجباری می باشد',
        ];
    }
}