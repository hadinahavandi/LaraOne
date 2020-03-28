<?php
namespace App\Http\Requests\publicrelations\message;
use App\Http\Requests\sweetRequest;

class publicrelations_messageListRequest extends publicrelations_messageRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'name'=>'name',
		'email'=>'email',
		'phonebnum'=>'phone_bnum',
		'messagetextte'=>'messagetext_te'
            ]);
    }
}