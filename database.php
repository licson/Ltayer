<?php
include('class/sql.class.php');
//include('config.php');

//Enter sql host
$config['sql']['host'] = 'nas.s3131212.com';
//Enter sql database name
$config['sql']['dbname'] = 'allenos';
//Enter database username
$config['sql']['username'] = 'webos';
//Enter database password
$config['sql']['password'] = '123';

//Initialization sql info
$db = new MySQL($config['sql']['dbname'], $config['sql']['username'], $config['sql']['password'], $config['sql']['host']);
$GLOBALS['db'] = $db;
?>