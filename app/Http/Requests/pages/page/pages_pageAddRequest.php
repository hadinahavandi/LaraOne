<?php
namespace App\Http\Requests\pages\page;
use App\Http\Requests\sweetRequest;
class pages_pageAddRequest extends pages_pageUpdateRequest
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
            'title.required' => 'وارد کردن عنوان اجباری می باشد',
            'contentte.required' => 'وارد کردن محتوا اجباری می باشد',
            'published.required' => 'وارد کردن منتشر شده اجباری می باشد',
            'keywords.required' => 'وارد کردن کلید واژه ها اجباری می باشد',
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