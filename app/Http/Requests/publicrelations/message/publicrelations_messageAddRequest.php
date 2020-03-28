<?php
namespace App\Http\Requests\publicrelations\message;
use App\Http\Requests\sweetRequest;
class publicrelations_messageAddRequest extends publicrelations_messageUpdateRequest
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
            'email.required' => 'وارد کردن ایمیل اجباری می باشد',
            'phonebnum.required' => 'وارد کردن تلفن همراه اجباری می باشد',
            'phonebnum.numeric' => 'مقدار تلفن همراه باید عدد انگلیسی باشد.',
            'messagetextte.required' => 'وارد کردن متن پیام اجباری می باشد',
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