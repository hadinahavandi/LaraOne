<?php
namespace App\Http\Requests\mail\mailpost;
use App\Http\Requests\sweetRequest;

class mail_mailpostListRequest extends mail_mailpostRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'subject'=>'subject',
		'contentte'=>'content_te',
		'name'=>'name'
            ]);
    }
}