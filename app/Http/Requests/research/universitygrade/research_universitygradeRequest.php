<?php
namespace App\Http\Requests\research\universitygrade;
use App\Http\Requests\sweetRequest;

class research_universitygradeRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
}