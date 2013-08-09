<?php
global $cfg;
$cfg = array();

$cfg["filesize_limit"] = 1024 * 1024 * 2; //檔案大小限制，預設2MB
$cfg["fileext_limit"] = array( //檔案格式限制
    'txt','md','rst', //文字檔案
	'jpg','jpeg','jfif','png','gif',
    'mp3','ogg','wav','wma','flac','au','alff','au','ape', //音訊檔案
    'ogv','webm','wmv','avi','mp4','mpeg','mpg','mkv', //視訊檔案
    'rar','zip','7z','tar','gz', //壓縮檔
    'doc','dot','xls','ppt','mdb', //MS Office 1997-2003 檔案
    'docx','dotx','xlsx','pptx','accdb' //MS Office 2007+ 檔案
);
