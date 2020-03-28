<?php
namespace App\Http\Requests\publicrelations\message;
use App\Http\Requests\sweetRequest;

class publicrelations_messageRequest extends sweetRequest
{
    
		public function getName(){return $this->getField('name',' ');}
		public function getEmail(){return $this->getField('email',' ');}
		public function getPhonebnum(){return $this->getNumberField('phonebnum');}
		public function getMessagetextte(){return $this->getField('messagetextte',' ');}
}