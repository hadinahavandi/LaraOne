<?php
namespace App\Http\Requests\research\universitygrade;
use App\Http\Requests\sweetRequest;

class research_universitygradeListRequest extends research_universitygradeRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name'
            ]);
    }
}