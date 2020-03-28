<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;

class comments_likeUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'comment' => 'required|min:-1|integer',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'comment.required' => 'وارد کردن نظر اجباری می باشد',
            'comment.integer' => 'مقدار نظر صحیح وارد نشده است.',
        ];
    }
}