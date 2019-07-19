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
        $api = new KavenegarApi("4C7265426A723248725437334B58303333346E48544F2B532F2B51597049734A724F4161516B5067556D4D3D");
        $status = $api->Send($this->getFromNumber(), $ToNumber, $Message);
        return $status;
    }
}