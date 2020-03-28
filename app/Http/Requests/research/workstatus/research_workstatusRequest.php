<?php
namespace App\Http\Requests\research\workstatus;
use App\Http\Requests\sweetRequest;

class research_workstatusRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
}