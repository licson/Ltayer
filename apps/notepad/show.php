<?php
$id = $_GET['id'];
include('appfunctions.php');
include('action/show_action.php');
load_template('_header');

include('templates/show.tpl.php');
load_template('_footer');

?>