<?php
namespace App\Http\Requests\mail\mailstatus;
use App\Http\Requests\sweetRequest;

class mail_mailstatusListRequest extends mail_mailstatusRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name'
            ]);
    }
}