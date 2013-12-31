<?php

class RestMethod {
    protected $server;
    protected $db;
    protected $args;
    
    public function __construct($server){
        $this->server = $server;
        $this->db = $server->db;
        $this->args = $server->args;
    }
    
    protected function checkPermissions($perms){
        $appPerms = $this->server->appPerms;
        $perms = explode(',', $perms);
        $result = false;
        
        foreach($perms as $perm){
			$r = stripos($perm, $appPerms);
            if($r >= 0 && $r !== false){
				$result = true;
			}
        }
        
        if(!$result){
            throw new RestException(RestException::PERMISSION_DENIED);
        }
    }
}