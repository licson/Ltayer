<?php
include_once(dirname(__FILE__).'/../db_connect.php');
$file = $DB->Select("notepad",array('id' => $id));