<?php
namespace App\Utility;
use Exception;

class RegistrationException extends Exception
{
    public function _construct($message, $code = 0, Exception $previous = null) {
        
        parent::_construct($message, $code, $previous);
    }
}

