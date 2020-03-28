<?php
namespace App\Http\Requests\pages\page;
use App\Http\Requests\sweetRequest;

class pages_pageRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
		public function getTitle(){return $this->getField('title',' ');}
		public function getContentte(){return $this->getField('contentte',' ');}
		public function getPublished(){return $this->getField('published',' ');}
		public function getKeywords(){return $this->getField('keywords',' ');}
}