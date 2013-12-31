<?php

class Util {
    public static function checkExt($path,$allows){
        if(count($allows) === 0) return true;
		
        $ext = strrchr($path,'.');
		return !in_array(strtolower(substr($ext,1)),$allows);
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
	
	public static function getUserDir(){
		return realpath('../../fs/data/') . '/' . $_SESSION['login_username'];
	}
    
	public static function getRelativePath($path){
		return str_replace(realpath(self::getUserDir()), '/', realpath($path));
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
            if($part != '.'){
				if($path == self::getUserDir() . '/' && $part == '..'){
					// Do nothing
				}
				else {
				    $file = iconv(mb_detect_encoding($part), 'UTF-8//TRANSLIT', $part);
				    
					$result[] = array(
						sprintf(
							'<a href="?d=%s" class="file-link" data-is-dir="%d" data-filename="%s" data-previeable="%d">%s</a>',
							is_dir(realpath($path) . '/' . $part) ? self::normalizePath(self::getRelativePath(realpath($path) . '/' . $file)) : '',
							is_dir(realpath($path) . '/' . $part),
							$file,
							self::isPreviewable($file),
							$file
						),
						is_file(realpath($path) . '/' . $part) ? '檔案' : (is_dir(realpath($path) . '/' . $part) ? '資料夾' : ''),
						is_file(realpath($path) . '/' . $part) ? self::formatByteSize(filesize(realpath($path) . '/' . $part)) : ''
					);
				}
            }
        }
        
        return $result;
    }
	
	public static function listDirOnly($path){
		$handle = opendir($path);
		$result = array();
		
		while(($part = readdir($handle)) !== false){
			if($part != '.' && $part != '..'){
				if(is_dir(realpath($path) . '/' . $part)){
					$result[] = array($part, self::listDirOnly(realpath($path) . '/' . $part));
				}
			}
		}
		
		return $result;
	}
	
	public static function showDirList($dirs, $base = '/'){
		$output = '<ul class="dir-tree">';
		
		if($base == '/'){
			$output .= '<li><a href="./?d=/">主目錄</a></li>';
		}
		
		if(count($dirs) !== 0){
			foreach($dirs as $dir){
				$output .= '<li><span class="tree-indicator"><i class="ion-ios7-minus-empty"></i></span> <a href="./?d=' . self::normalizePath($base . '/' .  $dir[0]) . '">' . $dir[0] . '</a>' . self::showDirList($dir[1], $base . '/' .  $dir[0]) . '</li>';
			}
		}
		$output .= '</ul>';
		
		return $output;
	}
	
	public static function normalizePath($path){
		$path = str_replace("\\", "/", $path);
		$path = preg_replace("/(\/)+/", "/", $path);
		return $path;
	}
	
	public static function isPreviewable($file){
		$_previeables = array('jpg', 'jpeg', 'png', 'gif', 'mp3', 'ogg', 'mp4', 'webm', 'txt');
		$ext = strtolower(substr(strrchr($file, '.'), 1));
		
		return in_array($ext, $_previeables);
	}
}