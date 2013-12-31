<?php
if(!session_id()){
	session_start();
}

$data = base64_decode(file_get_contents('php://input'));
$name = 'webcam_' . date('Ymd_His') . '.png';
$path = realpath('../../fs/data/' . $_SESSION['login_username'] . '/') . '/' . $name;

file_put_contents($path, $data);

echo "Success!";