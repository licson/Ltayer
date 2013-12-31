<?php

class RestException extends Exception {
    const METHOD_NOT_EXISTS = 100;
    const MALFORMED_DATA = 101;
    const METHOD_CANNOT_COMPLETE = 102;
    const APP_NOT_AUTHORIZED = 103;
    const ARGUMENT_MISSING = 104;
    const PERMISSION_DENIED = 105;
    
    public $errorTable;
    
    public function __construct($code, $message = null){
        $this->errorTable = array(
            100 => "The method requested does not exists",
            101 => "The method returns an malformed data. Please report to the Ltay Team if you encounter this.",
            102 => "Unable to finish this action due to failures.",
            103 => "The app is not authorized to use the REST API.",
            104 => "Missing argument for this method.",
            105 => "The app is not allowed to perform this action."
        );
        
        $message = ($message == null ? $this->errorTable[$code] : $message);
        
        parent::__construct($message, $code);
    }
    
    public function getErrorCode(){
        return $this->code;
    }
}