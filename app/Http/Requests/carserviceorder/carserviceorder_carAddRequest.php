<?php
namespace App\Http\Requests\carserviceorder;
use App\Http\Requests\sweetRequest;
class carserviceorder_carAddRequest extends carserviceorder_carUpdateRequest
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
            
            'title.required' => 'وارد کردن عنوان اجباری می باشد',
            'maxmodelnum.required' => 'وارد کردن حداکثر مدل اجباری می باشد',
            'maxmodelnum.numeric' => 'مقدار حداکثر مدل باید عدد انگلیسی باشد.',
            'minmodelnum.required' => 'وارد کردن حداقل مدل اجباری می باشد',
            'minmodelnum.numeric' => 'مقدار حداقل مدل باید عدد انگلیسی باشد.',
            'photoigu.required' => 'وارد کردن تصویر اجباری می باشد',
            'carmaker.required' => 'وارد کردن خودروساز اجباری می باشد',
            'carmaker.integer' => 'مقدار خودروساز صحیح وارد نشده است.',
        ];
    }
}