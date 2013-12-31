<?php
require_once('../../core/require.php');
require_once('utils.class.php');

if(isset($_GET['f'])){
	$path = $_GET['f'];
	$preview = isset($_GET['p']);
	$file = strrchr($path, '/');
	$ext = strtolower(substr(strrchr($file, '.'), 1));
	
	if(!$preview){
		header('Content-disposition: attachment; filename=' . trim($file, "/\\"));
	}
	else {
		$_mime = array(
			'mp3' => 'audio/mpeg',
			'ogg' => 'audio/ogg',
			'wav' => 'audio/x-wave',
			'mp4' => 'video/mp4',
			'webm' => 'video/webm',
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
			'txt' => 'text/plain'
		);
		$mime = isset($_mime[$ext]) ? $_mime[$ext] : 'application/octet-stream';
		
		header('Content-type: ' . $mime);
	}
	
	$dpath = '';
	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
	    $dpath = iconv('UTF-8', 'BIG-5', Util::getUserDir() . $path);
	}
	else {
	    $dpath = Util::getUserDir() . $path;
	}
	
	header('Content-length: ' . filesize($dpath));
	@readfile($dpath);
	ob_flush();
	flush();
}