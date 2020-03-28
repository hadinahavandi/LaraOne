<?php
namespace App\Http\Requests\trapp;
use App\Http\Requests\sweetRequest;
class trapp_villanonfreeoptionAddRequest extends trapp_villanonfreeoptionUpdateRequest
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
            
            'villa.required' => 'وارد کردن ویلا اجباری می باشد',
            'villa.integer' => 'مقدار ویلا صحیح وارد نشده است.',
            'option.required' => 'وارد کردن گزینه اجباری می باشد',
            'option.integer' => 'مقدار گزینه صحیح وارد نشده است.',
            'optional.required' => 'وارد کردن اختیاری اجباری می باشد',
            'pricenum.required' => 'وارد کردن قیمت اجباری می باشد',
            'pricenum.numeric' => 'مقدار قیمت باید عدد انگلیسی باشد.',
            'maxcountnum.required' => 'وارد کردن حداکثر تعداد اجباری می باشد',
            'maxcountnum.numeric' => 'مقدار حداکثر تعداد باید عدد انگلیسی باشد.',
        ];
    }
}