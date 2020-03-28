<?php
namespace App\Http\Requests\comments;
use App\Http\Requests\sweetRequest;
class comments_commentAddRequest extends comments_commentUpdateRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $Fields = [
            'ratenum' => 'required|numeric',
        ];
        
        $Fields = array_merge($Fields, parent::rules());
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'text.required' => 'وارد کردن متن اجباری می باشد',
            'ratenum.required' => 'وارد کردن نرخ اجباری می باشد',
            'ratenum.numeric' => 'مقدار نرخ باید عدد انگلیسی باشد.',
        ];
    }
}