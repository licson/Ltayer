<?php

require_once('restexception.php');
require_once('methodloader.php');

class RestHandler {
    public $server;
    public $component;
    public $loader;
    
    public function __construct($method, $server){
        $this->server = $server;
        $this->loader = new RestMethodLoader();
        $method = strtolower($method);
        
        if($this->loader->hasMethod($method)){
            $method = $this->filterMethodName($method);
            
            $this->component = new $method($this->server);
            if(!$this->component instanceof RestMethod){
                throw new RestException(RestException::METHOD_NOT_EXISTS);
            }
        }
        else {
            throw new RestException(RestException::METHOD_NOT_EXISTS);
        }
    }
    
    public function filterMethodName($name){
        return str_replace('.', '_', $name);
    }
    
    public function response(){
        $data = new RestData($this->server);
        $this->component->process($data);
        
        return $data;
    }
}