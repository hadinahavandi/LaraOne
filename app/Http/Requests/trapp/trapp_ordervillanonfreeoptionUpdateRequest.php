<?php
namespace App\Http\Requests\trapp;
use App\Http\Requests\sweetRequest;

class trapp_ordervillanonfreeoptionUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            
            'order' => 'required|min:-1|integer',
            'villanonfreeoption' => 'required|min:-1|integer',
            'countnum' => 'required|numeric',
            'pricenum' => 'required|numeric',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'order.required' => 'وارد کردن سفارش اجباری می باشد',
            'order.integer' => 'مقدار سفارش صحیح وارد نشده است.',
            'villanonfreeoption.required' => 'وارد کردن villanonfreeoption_fid اجباری می باشد',
            'villanonfreeoption.integer' => 'مقدار villanonfreeoption_fid صحیح وارد نشده است.',
            'countnum.required' => 'وارد کردن تعداد اجباری می باشد',
            'countnum.numeric' => 'مقدار تعداد باید عدد انگلیسی باشد.',
            'pricenum.required' => 'وارد کردن قیمت اجباری می باشد',
            'pricenum.numeric' => 'مقدار قیمت باید عدد انگلیسی باشد.',
        ];
    }
}