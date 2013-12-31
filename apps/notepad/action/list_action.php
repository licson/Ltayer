<?php
if(!session_id()){
    session_start();
}

include(dirname(__FILE__) . '/../appfunctions.php');
include(dirname(__FILE__) . '/../db_connect.php');
$file = $DB->Select("notepad", array(
    'user_name' => $_SESSION['login_username']
), 'id DESC');