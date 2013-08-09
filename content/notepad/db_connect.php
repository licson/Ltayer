<?php
include(dirname(__FILE__).'/core/db_class.php');
	include(dirname(__FILE__).'/appconfig.php');
	$DB = new MySQL($cfg['cfg']['db_name'],
		$cfg['cfg']['username'],
		$cfg['cfg']['password'],
		$cfg['cfg']['host']);
//require_once(dirname(__FILE__).'/../../require.php');
//require_once(dirname(__FILE__).'/../../database.php');
//$DB = $db;
?>