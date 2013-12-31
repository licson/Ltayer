<?php
if(!session_id()) session_start();
require('database/database.php');

function KMPMatch($a, $b){
	$lenA = strlen($a);
	$lenB = strlen($b);
	$pos = false;
	
	for($i = 0; $i < $lenA - $lenB; $i++){
		$chunk = substr($a, $i, $lenB);
		if($chunk == $b){
			$pos = $i;
			break;
		}
	}
	return substr($a, 0, $pos);
}

!isset($_GET['url']) && die('No app url supplied.');

$url = $_GET['url'];
$mobile = isset($_GET['mobile']);
$host = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$host = KMPMatch($host, 'app_proxy');

$appended_payload = base64_encode(json_encode(array(
    "ltayer_api_host" => $host . 'api/',
    "ltayer_host" => $host,
    "sessid" => session_id(),
    "is_mobile" => $mobile
)));

if(strpos($url, '?') !== false){
    $url .= '&ltayer=' . $appended_payload;
}
else {
    $url .= '?ltayer=' . $appended_payload;
}

header('Location: ' . $url);