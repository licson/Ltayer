<?php
include(dirname(__FILE__) . "/../class/sql.class.php");
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