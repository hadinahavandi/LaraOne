<?php
namespace App\Http\Requests\pages\page;
use App\Http\Requests\sweetRequest;

class pages_pageUpdateRequest extends pages_pageRequest
{
    public function rules()
    {
        $Fields = [
            
            'name' => 'required',
            'title' => 'required',
            'contentte' => 'required',
            'published' => 'required',
            'keywords' => 'required',
        ];
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