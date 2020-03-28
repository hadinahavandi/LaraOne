<?php
namespace App\Http\Requests\posts\category;
use App\Http\Requests\sweetRequest;
class posts_categoryAddRequest extends posts_categoryUpdateRequest
{
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
            'latinname.required' => 'وارد کردن نام لاتین اجباری می باشد',
            'mothercategory.required' => 'وارد کردن دسته مادر اجباری می باشد',
            'mothercategory.integer' => 'مقدار دسته مادر صحیح وارد نشده است.',
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