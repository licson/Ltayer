<?php

require_once('restmethod.php');
require_once('restexception.php');

class settings_delete extends RestMethod {
    public function process(&$dataInterface){
        $this->checkPermissions('PERMISSION_CHANGE_SETTINGS');
		
		if(!isset($this->args->name) || trim($this->args->name) == ""){
			throw new RestException(RestException::ARGUMENT_MISSING);
		}
		
        $name = $this->args->name;
        if(!$this->server->db->delete('setting', array('name' => $name))){
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE);
        }
    }
}