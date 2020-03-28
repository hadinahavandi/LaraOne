<?php
namespace App\Http\Requests\mail\mail;
use App\Http\Requests\sweetRequest;

class mail_mailListRequest extends mail_mailRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'mailpost'=>'mailpost_fid',
		'email'=>'email',
		'mailstatus'=>'mailstatus_fid'
            ]);
    }
}