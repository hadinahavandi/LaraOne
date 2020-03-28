<?php
namespace App\Http\Requests\mail\mailpost;
use App\Http\Requests\sweetRequest;
class mail_mailpostAddRequest extends mail_mailpostUpdateRequest
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
            
            'subject.required' => 'وارد کردن موضوع اجباری می باشد',
            'contentte.required' => 'وارد کردن محتوا اجباری می باشد',
            'name.required' => 'وارد کردن نام اجباری می باشد',
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