<?php
namespace App\Http\Requests\pages\page;
use App\Http\Requests\sweetRequest;

class pages_pageListRequest extends pages_pageRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name',
		'title'=>'title',
		'contentte'=>'content_te',
		'published'=>'is_published',
		'keywords'=>'keywords'
            ]);
    }
}