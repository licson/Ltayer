<?php

require_once('restexception.php');

class RestData {
    public $itemCount = 0;
    private $data = null;
    private $db;
	private $server;
    
    public function __construct($server){
        $this->db = $server->db;
        $this->server = $server;
    }
    
    public function selectAsData($table, $criteria = null){
		if(is_array($criteria)){
			$this->setData($this->db->select($table, $criteria));
		}
		else {
			$this->setData($this->db->select($table));
		}
    }
    
    public function updateAsData($table, $data, $criteria){
		$result = $this->db->update($table, $data, $criteria);
		if(!$result){
			throw new RestException(RestException::METHOD_CANNOT_COMPLETE);
		}
    }
    
    public function insertAsData($table, $data){
		$result = $this->db->insert($data, $table);
		if(!$result){
			throw new RestException(RestException::METHOD_CANNOT_COMPLETE);
		}
    }
    
    public function setData($data){
        $this->data = $data;
        $this->itemCount = count($data);
    }
    
    public function getBody(){
        return $this->data;
    }
}