<?php

class Util {
    public static function checkExt($path,$allows){
        if(count($allows) === 0) return true;
		
        $ext = strrchr($path,'.');
		return in_array(strtolower(substr($ext,1)),$allows);
    }
    
    public static function formatByteSize($size,$precision = 2){
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
        
        $size = max($size, 0); 
        $pow = floor(($size ? log($size) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        
        // $size /= pow(1024, $pow);
        $size /= (1 << (10 * $pow)); //這個快很多
        
        return round($size, $precision) . $units[$pow]; 
    }
    
    public static function printTable($arr,$override = array()){
        $keys = count($override) === 0 ? array_keys(@$arr[0]) : $override;
        
        $output = '<table class="table table-striped"><thead>';
        foreach($keys as $k => $d){
            $output .= '<th>'.(count($override) === 0 ? $k : $d).'</th>';
        }
        
        $output .= '</thead><tbody>';
        foreach($arr as $data){
            $output .= '<tr>';
            foreach($keys as $k => $d){
                $output .= '<td>'.$data[count($override) === 0 ? $d : $k].'</td>';
            }
            $output .= '</tr>';
        }
        
        $output .= '</tbody></table>';
        
        return $output;
    }
    
    public static function listDir($path){
        $handle = opendir($path);
        $result = array();
        
        while(($part = readdir($handle)) !== false){
            if($part != '..' && $part != '.'){
    			$file = iconv(mb_detect_encoding($part),'UTF-8//TRANSLIT',$part);
                $result[] = array(
                    sprintf('<a href="%s%s" class="file-link" data-is-dir="%d">%s</a>',$path,$file,is_dir($path.$part),$file),
                    is_file($path.$part) ? '檔案' : (is_dir($path.$part) ? '資料夾' : ''),
                    is_file($path.$part) ? self::formatByteSize(filesize($path.$part)) : ''
                );
            }
        }
        
        return $result;
    }
}