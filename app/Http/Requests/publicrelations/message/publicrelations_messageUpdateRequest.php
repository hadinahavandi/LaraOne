<?php
namespace App\Http\Requests\publicrelations\message;
use App\Http\Requests\sweetRequest;

class publicrelations_messageUpdateRequest extends publicrelations_messageRequest
{
    public function rules()
    {
        $Fields = [
            
            'name' => 'required',
            'email' => 'required',
            'phonebnum' => 'required|numeric',
            'messagetextte' => 'required',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'name.required' => 'وارد کردن نام اجباری می باشد',
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'phonebnum.required' => 'وارد کردن تلفن همراه اجباری می باشد',
            'phonebnum.numeric' => 'مقدار تلفن همراه باید عدد انگلیسی باشد.',
            'messagetextte.required' => 'وارد کردن متن پیام اجباری می باشد',
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