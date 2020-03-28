<?php
namespace App\Http\Requests\posts\category;
use App\Http\Requests\sweetRequest;

class posts_categoryListRequest extends posts_categoryRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name',
		'latinname'=>'latinname',
		'mothercategory'=>'mother__category_fid'
            ]);
    }
}