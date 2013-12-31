<?php
//if(isset($_POST['submit']) && $_POST['submit'] != ""){
include(dirname(__FILE__).'/../db_connect.php');
$file = $DB->Delete("notepad", array('id' => $id));