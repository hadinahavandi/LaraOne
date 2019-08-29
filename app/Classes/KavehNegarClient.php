<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 6/3/2019
 * Time: 3:04 AM
 */

namespace App\Classes;

use Kavenegar\KavenegarApi;
use SoapClient;

class KavehNegarClient extends NumberMessagingPanelClient
{

    public function sendMessage($ToNumber, $Message)
    {
        $api = new KavenegarApi("7A684F53506B7141394E395744576A3549476162416B4C56596B6C6C683661774D55614D535A4C557141383D");
        $status = $api->Send($this->getFromNumber(), $ToNumber, $Message);
        return $status;
    }

    public function sendTokenMessage($ToNumber, $Token1, $Token2, $Token3, $template)
    {
        $api = new KavenegarApi("7A684F53506B7141394E395744576A3549476162416B4C56596B6C6C683661774D55614D535A4C557141383D");
        $status = $api->VerifyLookup($ToNumber, $Token1, $Token2, $Token3, $template);
        return $status;
    }
}