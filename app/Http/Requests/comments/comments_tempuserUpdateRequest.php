<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;

class comments_tempuserUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'name' => 'required',
            'family' => 'required',
            'mobilenum' => 'required|numeric',
            'email' => 'required',
            'telnum' => 'required|numeric',
        ];
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