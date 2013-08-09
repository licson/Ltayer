<?php
$id = $_GET['id'];
include('appfunctions.php');
//include('action/show_action.php?id='.$id);
include('helper/get_content.helper.php');

//$file_name = $file['name'];
//$file_content = $file['content'];



load_template('_header');
include('templates/edit_form.tpl.php');
load_template('_footer');

?>