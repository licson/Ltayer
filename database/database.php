<?php
include_once(dirname(__FILE__) . "/../class/sql.class.php");/*因notepad需要而改用"include_once" 順便避免多次引用 但在部分測試中有安裝失敗之可能*/
//include('config.php');

//Enter sql database name
$config['sql']['dbname'] = '';
//Enter database username
$config['sql']['username'] = '';
//Enter database password
$config['sql']['password'] = '';
//Enter sql host
$config['sql']['host'] = '';

//Initialization sql info
$db = new MySQL($config['sql']['dbname'], $config['sql']['username'], $config['sql']['password'], $config['sql']['host']);
$GLOBALS['db'] = $db;
$DB = $db;