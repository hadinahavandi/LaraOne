<?php
namespace App\Http\Requests\research\workstatus;
use App\Http\Requests\sweetRequest;

class research_workstatusListRequest extends research_workstatusRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name'
            ]);
    }
}