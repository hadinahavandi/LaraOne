<?php
namespace App\Http\Requests\mail\mailpost;
use App\Http\Requests\sweetRequest;

class mail_mailpostRequest extends sweetRequest
{
    
		public function getSubject(){return $this->getField('subject',' ');}
		public function getContentte(){return $this->getField('contentte',' ');}
		public function getName(){return $this->getField('name',' ');}
}