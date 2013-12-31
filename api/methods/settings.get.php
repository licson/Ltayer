<?php

require_once('restmethod.php');
require_once('restexception.php');

class settings_get extends RestMethod {
    public function process($dataInterface){
        if(count($this->args) == 0){
            throw new RestException(RestException::ARGUMENT_MISSING);
        }
        else {
            if(isset($this->args->all) && $this->args->all === true){
                $dataInterface->selectAsData('setting');
            }
            else if(isset($this->args->name)){
                $dataInterface->selectAsData('setting', array(
                    "name" => $this->args->name
                ));
            }
        }
    }
}