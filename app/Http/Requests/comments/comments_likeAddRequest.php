<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;
class comments_likeAddRequest extends comments_likeUpdateRequest
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
            
            'comment.required' => 'وارد کردن نظر اجباری می باشد',
            'comment.integer' => 'مقدار نظر صحیح وارد نشده است.',
            'user.required' => 'وارد کردن کاربر اجباری می باشد',
            'user.integer' => 'مقدار کاربر صحیح وارد نشده است.',
        ];
    }
}