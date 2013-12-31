<?php

require_once('restmethod.php');
require_once('restexception.php');

class app_uninstall extends RestMethod {
    public function process($dataInterface){
        $this->checkPermissions('PERMISSION_MANAGE_APPS');
        
        if(count($this->args) == 0 || !isset($this->args->key) || trim($this->args->key) == "" || $this->args->key === null){
            throw new RestException(RestException::ARGUMENT_MISSING);
        }
        
        if(!$this->db->delete('app', array('app_key' => $this->args->key, 'is_system_app' => false))){
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE, 'Error writing to database.');
        }
    }
}