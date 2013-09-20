<?php
include('class/sql.class.php');
//include('config.php');

//Enter sql host
$config['sql']['host'] = 'Mysql伺服器';
//Enter sql database name
$config['sql']['dbname'] = 'Mysql資料庫名稱';
//Enter database username
$config['sql']['username'] = 'Mysql帳號';
//Enter database password
$config['sql']['password'] = 'Mysql密碼';

//Initialization sql info
$db = new MySQL($config['sql']['dbname'], $config['sql']['username'], $config['sql']['password'], $config['sql']['host']);
$GLOBALS['db'] = $db;
?>
