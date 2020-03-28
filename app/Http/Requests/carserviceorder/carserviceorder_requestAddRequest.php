<?php
namespace App\Http\Requests\carserviceorder;
use App\Http\Requests\sweetRequest;
class carserviceorder_requestAddRequest extends carserviceorder_requestUpdateRequest
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

            'latitudeflt.required' => 'وارد کردن عرض جغرافیایی اجباری می باشد',
            'latitudeflt.numeric' => 'مقدار عرض جغرافیایی باید عدد انگلیسی باشد.',
            'longitudeflt.required' => 'وارد کردن طول جغرافیایی اجباری می باشد',
            'longitudeflt.numeric' => 'مقدار طول جغرافیایی باید عدد انگلیسی باشد.',
            'carmakeyearnum.required' => 'وارد کردن مدل خودرو اجباری می باشد',
            'carmakeyearnum.numeric' => 'مقدار مدل خودرو باید عدد انگلیسی باشد.',
            'car.required' => 'وارد کردن خودرو اجباری می باشد',
            'car.integer' => 'مقدار خودرو صحیح وارد نشده است.',
        ];
    }
}