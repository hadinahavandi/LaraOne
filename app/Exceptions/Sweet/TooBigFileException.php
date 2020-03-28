<?php


namespace App\Exceptions\Sweet;


use Mockery\Exception;
use Throwable;

class TooBigFileException extends Exception
{
    public function __construct($message = "", $code = 1148500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}