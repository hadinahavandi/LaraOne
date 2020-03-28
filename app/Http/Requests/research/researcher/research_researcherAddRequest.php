<?php
namespace App\Http\Requests\research\researcher;
use App\Http\Requests\sweetRequest;
class research_researcherAddRequest extends research_researcherUpdateRequest
{
    public function rules()
    {
        $Fields = [
            'password' => 'required|min:8',
        ];
        
        $Fields = array_merge($Fields, parent::rules());
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'password.required' => 'وارد کردن رمز اجباری می باشد',
            'password.min' => 'طول رمز کوتاه است',
            'user.required' => 'وارد کردن کاربر اجباری می باشد',
            'user.integer' => 'مقدار کاربر صحیح وارد نشده است.',
            'name.required' => 'وارد کردن نام اجباری می باشد',
            'family.required' => 'وارد کردن نام خانوادگی اجباری می باشد',
            'university.required' => 'وارد کردن دانشگاه اجباری می باشد',
            'studyfield.required' => 'وارد کردن رشته تحصیلی اجباری می باشد',
            'interestarea.required' => 'وارد کردن گرایش اجباری می باشد',
            'telnum.required' => 'وارد کردن تلفن اجباری می باشد',
            'telnum.numeric' => 'مقدار تلفن باید عدد انگلیسی باشد.',
            'mobnum.required' => 'وارد کردن تلفن همراه اجباری می باشد',
            'mobnum.numeric' => 'مقدار تلفن همراه باید عدد انگلیسی باشد.',
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'workstatus.required' => 'وارد کردن وضعیت اشتغال اجباری می باشد',
            'workstatus.integer' => 'مقدار وضعیت اشتغال صحیح وارد نشده است.',
            'jobfield.required' => 'وارد کردن زمینه شغلی اجباری می باشد',
            'role.required' => 'وارد کردن سمت اجباری می باشد',
            'bankcardbnum.required' => 'وارد کردن کارت بانکی اجباری می باشد',
            'bankcardbnum.numeric' => 'مقدار کارت بانکی باید عدد انگلیسی باشد.',
            'licenceigu.required' => 'انتخاب مدرک تحصیلی اجباری می باشد',
            'licenceigu.max' => 'حداکثر حجم مدرک تحصیلی انتخاب شده ۲ مگابایت می باشد',
            'city.required' => 'وارد کردن شهر اجباری می باشد',
            'area.required' => 'وارد کردن منطقه اجباری می باشد',
            'birthyearnum.required' => 'وارد کردن سال تولد اجباری می باشد',
            'birthyearnum.numeric' => 'مقدار سال تولد باید عدد انگلیسی باشد.',
            'male.required' => 'وارد کردن جنسیت اجباری می باشد',
        ];
    }
    
    public function authorize()
    {
        return true;
    }
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setRequestMethod(sweetRequest::$REQUEST_METHOD_POST);
    }
}