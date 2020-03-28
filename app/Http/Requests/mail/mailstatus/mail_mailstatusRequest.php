<?php
namespace App\Http\Requests\mail\mailstatus;
use App\Http\Requests\sweetRequest;

class mail_mailstatusRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
}