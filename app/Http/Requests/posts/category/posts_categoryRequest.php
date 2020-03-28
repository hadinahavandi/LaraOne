<?php
namespace App\Http\Requests\posts\category;
use App\Http\Requests\sweetRequest;

class posts_categoryRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
		public function getLatinname(){return $this->getField('latinname',' ');}
		public function getMothercategory(){return $this->getNumberField('mothercategory',-1);}
}