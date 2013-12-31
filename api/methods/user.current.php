<?php

require_once('restmethod.php');
require_once('restexception.php');

class user_current extends RestMethod {
    public function process(&$dataInterface){
        if(count($this->args) == 0 || !isset($this->args->session_id) || !$this->args->session_id){
            throw new RestException(RestException::ARGUMENT_MISSING);
        }
        
        session_id($this->args->session_id);
        session_start();
        
        $dataInterface->selectAsData("user", array( "username" => $_SESSION['login_username'] ));
    }
}