<?php
namespace App\Http\Requests\posts\category;
use App\Http\Requests\sweetRequest;

class posts_categoryUpdateRequest extends posts_categoryRequest
{
    public function rules()
    {
        $Fields = [
            
            'name' => 'required',
            'latinname' => 'required',
            'mothercategory' => 'required|min:-1|integer',
        ];
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
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setRequestMethod(sweetRequest::$REQUEST_METHOD_PUT);
    }
    public function authorize()
    {
        return true;
    }
}