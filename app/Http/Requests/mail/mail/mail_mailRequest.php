<?php
namespace App\Http\Requests\mail\mail;
use App\Http\Requests\sweetRequest;

class mail_mailRequest extends sweetRequest
{
    
		public function getMailpost(){return $this->getNumberField('mailpost',-1);}
		public function getEmail(){return $this->getField('email',' ');}
		public function getMailstatus(){return $this->getNumberField('mailstatus',-1);}
}