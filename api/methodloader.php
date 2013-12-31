<?php

class RestMethodLoader {
    public $methods;
    
    public function __construct(){
        $this->methods = array();
        $this->findMethods();
        $this->preload();
    }
    
    private function findMethods(){
        $handle = opendir('./methods/');
        while(($method = readdir($handle)) !== false){
            if($method == '.' || $method == '..' || substr($method, 0, 1) == '@'){
                continue;
            }
            
            $this->methods[] = $method;
        }
    }
    
    public function preload(){
        foreach($this->methods as $method){
            require_once('./methods/' . $method);
        }
    }
    
    public function hasMethod($method){
        return in_array($method . '.php', $this->methods);
    }
}