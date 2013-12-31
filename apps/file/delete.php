<?php
require_once('../../core/require.php');
require_once('utils.class.php');

function rrmdir($dir) {
	if(is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

if(isset($_GET['f'])){
	$file = $_GET['f'];
	unlink(Util::getUserDir() . '/' . $file);
	header("Location: index.php?d=" . Util::getRelativePath(Util::getUserDir() . '/' . dirname($file)));
	die();
}

if(isset($_GET['d'])){
	$dir = $_GET['d'];
	rrmdir(Util::getUserDir() . '/' . $dir);
	header("Location: index.php?d=/");
	die();
}