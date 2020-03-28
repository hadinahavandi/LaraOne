<?php
namespace App\Http\Requests\research\workstatus;
use App\Http\Requests\sweetRequest;

class research_workstatusUpdateRequest extends research_workstatusRequest
{
    public function rules()
    {
        $Fields = [
            
            'name' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
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