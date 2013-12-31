<?php

class Preview {
	public $ext;
	public $path;
	
	public function __construct($path){
		$this->ext = strtolower(substr(strrchr($path, '.') , 1));
		$this->path = $path;
	}
	
	protected function getDownloadPath(){
		return 'download.php?f=' . urlencode($this->path) . '&amp;p=1';
	}
	
	protected function renderAudioPlayer(){
		return sprintf(
			'<audio src="%s" controls style="width:100%%;">你的瀏覽器不支援HTML5 Audio</audio>',
			$this->getDownloadPath()
		);
	}
	
	protected function renderVideoPlayer(){
		return sprintf(
			'<video src="%s" controls style="max-width: 100%%;">你的瀏覽器不支援HTML5 Video</audio>',
			$this->getDownloadPath()
		);
	}
	
	protected function renderPicture(){
		return sprintf(
			'<img src="%s" style="max-width: 100%%; margin: 1em auto; display: block;" />',
			$this->getDownloadPath()
		);
	}
	
	protected function readFile(){
		return sprintf(
			'<pre>%s</pre>',
			file_get_contents(Util::getUserDir() . $this->path)
		);
	}
	
	public function renderHTML(){
		switch($this->ext){
			case "mp3":
			case "ogg":
			case "wav":
			return $this->renderAudioPlayer();
			break;
			
			case "mp4":
			case "webm":
			return $this->renderVideoPlayer();
			break;
			
			case "jpg":
			case "jpeg":
			case "gif":
			case "png":
			return $this->renderPicture();
			break;
			
			default:
			return $this->readFile();
			break;
		}
	}
}