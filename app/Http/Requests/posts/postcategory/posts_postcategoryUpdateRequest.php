<?php
namespace App\Http\Requests\posts\postcategory;
use App\Http\Requests\sweetRequest;

class posts_postcategoryUpdateRequest extends posts_postcategoryRequest
{
    public function rules()
    {
        $Fields = [
            
            'post' => 'required|min:-1|integer',
            'category' => 'required|min:-1|integer',
        ];
        return $Fields;
    }
    public function messages()
    {
        return [
            
            'post.required' => 'وارد کردن مطلب اجباری می باشد',
            'post.integer' => 'مقدار مطلب صحیح وارد نشده است.',
            'category.required' => 'وارد کردن دسته بندی اجباری می باشد',
            'category.integer' => 'مقدار دسته بندی صحیح وارد نشده است.',
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