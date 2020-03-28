<?php
namespace App\Http\Requests\mail\mailpost;
use App\Http\Requests\sweetRequest;

class mail_mailpostUpdateRequest extends mail_mailpostRequest
{
    public function rules()
    {
        $Fields = [
            
            'subject' => 'required',
            'contentte' => 'required',
            'name' => 'required',
        ];
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