<?php

require_once('restmethod.php');
require_once('restexception.php');

class settings_set extends RestMethod {
	public function process($dataInterface){
		$this->checkPermissions('PERMISSION_CHANGE_SETTINGS');
		
		if($this->server->isPost()){
			$name = $this->server->getPostInput('name');
			$value = $this->server->getPostInput('value');
			$rs = $this->server->db->select('setting', array('name' => $name));
			
			if(isset($name) && isset($value)){
				if(is_array($rs) && count($rs) > 0){
					$dataInterface->updateAsData('setting', array('value' => $value), array('name' => $name));
				}
				else {
					$dataInterface->insertAsData('setting', array('name' => $name, 'value' => $value));
				}
			}
			else {
				throw new RestException(RestException::ARGUMENT_MISSING);
			}
		}
		else {
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE, 'This method only accepts HTTP POST requests.');
        }
    }
}