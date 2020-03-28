<?php
namespace App\Http\Requests\posts\postcategory;
use App\Http\Requests\sweetRequest;

class posts_postcategoryListRequest extends posts_postcategoryRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'post'=>'post_fid',
		'category'=>'category_fid'
            ]);
    }
}