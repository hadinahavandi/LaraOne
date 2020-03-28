<?php
namespace App\Http\Requests\appman;
use App\Http\Requests\sweetRequest;
class appman_apperrorAddRequest extends appman_apperrorUpdateRequest
{
    public function authorize()
    {
        return true;
    }
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

        ];
    }
}