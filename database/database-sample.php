<?php
include(dirname(__FILE__) . "/../class/sql.class.php");
//include('config.php');

//Enter sql database name
$config['sql']['dbname'] = '%s';
//Enter database username
$config['sql']['username'] = '%s';
//Enter database password
$config['sql']['password'] = '%s';
//Enter sql host
$config['sql']['host'] = '%s';

$db = new MySQL($config['sql']['dbname'], $config['sql']['username'], $config['sql']['password'], $config['sql']['host']);
$GLOBALS['db'] = $db;
$DB = $db;