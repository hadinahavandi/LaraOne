<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 6/3/2019
 * Time: 3:04 AM
 */

namespace App\Classes;

use SoapClient;

abstract class NumberMessagingPanelClient
{
    private $FromNumber = "";

    /**
     * @return string
     */
    public function getFromNumber(): string
    {
        return $this->FromNumber;
    }

    /**
     * @param string $FromNumber
     */
    public function setFromNumber(string $FromNumber): void
    {
        $this->FromNumber = $FromNumber;
    }

    /**
     * OnlinePanelClient constructor.
     * @param string $FromNumber
     */
    public function __construct(string $FromNumber)
    {
        $this->FromNumber = $FromNumber;
    }

    public abstract function sendMessage($ToNumber, $Message);
}