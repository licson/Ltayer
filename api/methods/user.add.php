<?php

require_once('restmethod.php');
require_once('restexception.php');

class user_add extends RestMethod {
    public function process(&$dataInterface){
        $this->checkPermissions('PERMISSION_CHANGE_USER');
        
        if($this->server->isPost()){
            $email = $this->server->getPostInput('email');
            $admin = $this->server->getPostInput('admin');
            
            if(!$this->server->getPostInput('name')) throw new RestException(RestException::ARGUMENT_MISSING);
            if(!$this->server->getPostInput('password')) throw new RestException(RestException::ARGUMENT_MISSING);
            if(!$this->server->getPostInput('email')) $email = null;
            if(!$this->server->getPostInput('admin')) $admin = false;
            
            $username = $this->server->getPostInput('name');
            $password = $this->server->getPostInput('password');
    
            $users = $this->server->db->Select('user');
            
            foreach($users as $key => $value){
                if($value['username'] == $username){
                    throw new RestException(RestException::METHOD_CANNOT_COMPLETE, "User already exists!");
                }
            }
            
            if(trim($username) != "" && trim($password) != ""){
                $result = $this->server->db->insert(array(
                    'username' => $username,
                    'password' => md5(sha1($password)),
                    'email' => $email,
                    'admin' => $admin ? 'true' : 'false'
                ), 'user');
                
                if(!$result){
                    throw new RestException(RestException::METHOD_CANNOT_COMPLETE, "Error writing to database!");
                }
            } else {
                throw new RestException(RestException::METHOD_CANNOT_COMPLETE, "Invalid data. Username and password cannot be empty.");
            }
        }
        else {
            throw new RestException(RestException::METHOD_CANNOT_COMPLETE, 'This method only accepts HTTP POST requests.');
        }
    }
}