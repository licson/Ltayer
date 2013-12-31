<?php

require_once('restmethod.php');
require_once('restexception.php');

class user_delete extends RestMethod {
    public function process(&$dataInterface){
        $this->checkPermissions('PERMISSION_CHANGE_USER');
        
        if(!isset($this->args->id) || $this->args->id == null){
            throw new RestException(RestException::ARGUMENT_MISSING);
        }
        
        $id = $this->args->id;

        $users = $this->server->db->select('user', array( 'id' => $id));
        if(!is_array($users)){
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE, "User not exists!");
        }
        
        $result = $this->server->db->delete('user', array(
            'id' => $id
        ));
        
        if(!$result){
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE, "Error deleting record!");
        }
    }
}