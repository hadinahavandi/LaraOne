<?php
namespace App\Http\Requests\posts\postcategory;
use App\Http\Requests\sweetRequest;

class posts_postcategoryRequest extends sweetRequest
{
    
		public function getPost(){return $this->getNumberField('post',-1);}
		public function getCategory(){return $this->getNumberField('category',-1);}
}