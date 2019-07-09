<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 6/3/2019
 * Time: 3:04 AM
 */

namespace App\Classes;

use SoapClient;

class OnlinePanelClient
{
    private $FromNumber = "50002333333321";

    /**
     * OnlinePanelClient constructor.
     * @param string $FromNumber
     */
    public function __construct(string $FromNumber)
    {
        $this->FromNumber = $FromNumber;
    }

    public function sendSMS($ToNumber, $Message)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $user = "9367356253";
        $pass = "11472010";


        $client = new SoapClient("http://87.107.121.52/post/send.asmx?wsdl");

        $getcredit_parameters = array(
            "username" => $user,
            "password" => $pass
        );
        $credit = $client->GetCredit($getcredit_parameters)->GetCreditResult;
        echo "Credit: " . $credit . "<br />";

        $encoding = "UTF-8";//CP1256, CP1252
        $textMessage = iconv($encoding, 'UTF-8//TRANSLIT', $Message);

        $sendsms_parameters = array(
            'username' => $user,
            'password' => $pass,
            'from' => $this->FromNumber,
            'to' => array($ToNumber),
            'text' => $textMessage,
            'isflash' => false,
            'udh' => "",
            'recId' => array(0),
            'status' => 0
        );
        $status = $client->SendSms($sendsms_parameters)->SendSmsResult;
        return $status;
    }
}