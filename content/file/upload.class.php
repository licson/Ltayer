<?php
require_once('config.php');
require_once('utils.class.php');

class Upload {
    public $files;
    
    public function __construct($name){
        $this->files = array();
        foreach($_FILES[$name]['name'] as $k => $d){
            $this->files[] = array(
				'name' => $_FILES[$name]['name'][$k],
                'real_name' => sha1($_SESSION['login_username']).'_'.sha1($_FILES[$name]['name'][$k]).'.data',
                'size' => $_FILES[$name]['size'][$k],
                'tmp' => $_FILES[$name]['tmp_name'][$k]
            );
        }
    }
    
    public function check(){
        global $cfg;
        
        foreach($this->files as $d){
            if(!($d['size'] < $cfg['filesize_limit'] && Util::checkExt($d['name'],$cfg['fileext_limit']))){
                throw new Exception('檔案不通過測試。');
                return false;
            }
        }
        
        return true;
    }
    
    public function move($loc){
        foreach($this->files as $file){
            if(!move_uploaded_file($file['tmp'],$loc.'/'.$file['real_name'])){
                throw new Exception('無法移動檔案。');
                return false;
            }
        }
        return true;
    }
}