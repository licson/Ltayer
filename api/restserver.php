<?php
require_once('restexception.php');
require_once('resthandler.php');
require_once('restdata.php');
require_once('../database/database.php');

class RestServer {
    public $method;
    public $limit;
    public $offset;
    public $args;
    public $handler;
    public $db;
    public $appPerms;
    
    public function __construct(){
        $this->method = isset($_GET['method']) ? $_GET['method'] : null;
        $this->appKey = isset($_GET['key']) ? $_GET['key'] : null;
        
        $this->args = isset($_GET['args']) ? json_decode($_GET['args']) : array();
        $this->db = $GLOBALS['db'];
    }
	
    public function auth(){
        if($this->appKey == null){
            throw new RestException(RestException::ARGUMENT_MISSING, "The API Key is required to use the REST API or your API Key is incorrect.");
        }
        
        $rs = $this->db->select('app', array(
            'app_key' => $this->appKey
        ));
        
        if(count($rs) > 0 && is_array($rs)){
            $this->appPerms = $rs[0]['perms'];
            return true;
        }
        else {
            return false;
        }
    }
    
    public function response(){
        if(function_exists('apache_setenv')){
            @apache_setenv('no-gzip', 1);
        }
        
        @ini_set('zlib.output_compression', 0);
        @ini_set('implicit_flush', 1);
        
        for($i = 0; $i < ob_get_level(); $i++){
            ob_end_clean();
        }
        
        ob_implicit_flush(1);
        
        header('Content-Type: ' . (isset($_GET['callback']) ? 'text/javascript' : 'application/json'));
        header('Access-Control-Allow-Origin: *');
        
        try {
            if($this->auth()){
                $this->handler = new RestHandler($this->method, $this);
                $response = $this->handler->response();
                echo $this->formatResponse($response);
            }
            else {
                throw new RestException(RestException::APP_NOT_AUTHORIZED);
            }
        }
        catch(RestException $e){
            echo $this->formatResponse($e);
        }
        
        @ob_flush();
        @flush();
    }
    
    public function formatResponse($data){
        if($data instanceof RestException){
            return $this->makeJSONP(array(
                'status' => 'error',
                'error' => $data->getMessage(),
                'code' => $data->getErrorCode()
            ));
        }
        else if($data instanceof RestData){
            return $this->makeJSONP(array(
                'status' => 'success',
                'items' => $data->itemCount,
                'data' => $data->getBody()
            ));
        }
        else {
            throw new RestException(RestException::MALFORMED_DATA);
        }
    }
    
    private function makeJSONP($data){
        if(isset($_GET['callback'])){
            return $_GET['callback'] . '(' . json_encode($data) . ');';
        }
        else {
            return json_encode($data);
        }
    }
    
    public function isPost(){
        return (isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0);
    }
    
    public function getPostInput($field){
        if(!$this->isPost()){
            return;
        }
        
        // It's a file input
        if(isset($_FILES[$field])){
            // Reorder the data
            $result = array();
            foreach($_FILES[$field]['name'] as $k => $d){
                $result[] = array(
    				'name' => $d,
                    'size' => $_FILES[$field]['size'][$k],
                    'tmpfile' => $_FILES[$field]['tmp_name'][$k],
                    'error' => $_FILES[$field]['error'][$k]
                );
            }
            return $result;
        }
        
        if(isset($_POST[$field])){
            return $_POST[$field];
        }
    }
}

$server = new RestServer();
$server->response();