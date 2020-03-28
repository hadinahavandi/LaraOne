<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;
class comments_tempuserAddRequest extends comments_tempuserUpdateRequest
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
            
            'name.required' => 'وارد کردن نام اجباری می باشد',
            'family.required' => 'وارد کردن نام خانوادگی اجباری می باشد',
            'mobilenum.required' => 'وارد کردن موبایل اجباری می باشد',
            'mobilenum.numeric' => 'مقدار موبایل باید عدد انگلیسی باشد.',
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'telnum.required' => 'وارد کردن تلفن اجباری می باشد',
            'telnum.numeric' => 'مقدار تلفن باید عدد انگلیسی باشد.',
        ];
    }
}