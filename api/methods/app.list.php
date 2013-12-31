<?php

require_once('restmethod.php');
require_once('restexception.php');

class app_list extends RestMethod {
    public function process($dataInterface){
        $this->checkPermissions('PERMISSION_MANAGE_APPS');
        
        if(count($this->args) == 0){
            throw new RestException(RestException::ARGUMENT_MISSING);
        }
        
        if($this->args->all === true){
            $dataInterface->selectAsData('app');
        }
        else {
            $criteria = array();
            
            if(isset($this->args->name)) $criteria['name'] = $this->args->name;
            if(isset($this->args->appKey)) $criteria['app_key'] = $this->args->key;
            if(isset($this->args->canvas_url)) $criteria['canvas_url'] = $this->args->canvas_url;
            
            $dataInterface->selectAsData('app', $criteria);
        }
    }
}