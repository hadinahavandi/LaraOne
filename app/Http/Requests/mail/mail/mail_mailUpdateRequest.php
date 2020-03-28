<?php
namespace App\Http\Requests\mail\mail;
use App\Http\Requests\sweetRequest;

class mail_mailUpdateRequest extends mail_mailRequest
{
    public function rules()
    {
        $Fields = [
            
            'mailpost' => 'required|min:-1|integer',
            'email' => 'required',
            'mailstatus' => 'required|min:-1|integer',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'mailpost.required' => 'وارد کردن پست الکترونیکی اجباری می باشد',
            'mailpost.integer' => 'مقدار پست الکترونیکی صحیح وارد نشده است.',
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'mailstatus.required' => 'وارد کردن پست الکترونیکی اجباری می باشد',
            'mailstatus.integer' => 'مقدار پست الکترونیکی صحیح وارد نشده است.',
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