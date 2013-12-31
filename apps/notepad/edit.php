<?php
$id = $_GET['id'];
include('appfunctions.php');
//include('action/show_action.php?id='.$id);
include('helper/get_content.helper.php');


load_template('_header');
include('templates/edit_form.tpl.php');
load_template('_footer');
