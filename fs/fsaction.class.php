<?php

define('FSABSPATH', dirname(__FILE__));

class FSAction {
    public static function open($file, $mode){
        $f = fopen(FSABSPATH . '/data/' . $file, $mode);
        return $f;
    }
    
    public static function create($file){
        $f = @$this->open($file, 'w');
        if(!$f) return false;
        
        fwrite($f, '');
        fclose($f);
        
        return true;
    }
    
    public static function read($file){
        $f = $this->open($file, 'r');
        return $f;
    }
    
    public static function moveIn($src, $dest){
        return rename($src, realname(FSABSPATH . '/' . $dest));
    }
}