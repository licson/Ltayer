<?php
if(!session_id()) session_start();
require('../database/database.php');

$action = $_GET['action'];
$result = false;

switch($action){
    case "update_app_pos":
        $list = $_GET['app'];
        
        foreach($list as $pos => $id){
            $result = $db->update("app", array( "pos" => $pos ), array( "id" => $id ));
        }
    break;
    
    case "end_update_window_pos":
        if(count($db->select('setting', array("name" => "win_" . $_SESSION['login_username'] . "_pos" ))) == 0){
            $result = $db->insert(array(
                "name" => "win_" . $_SESSION['login_username'] . "_pos",
                "value" => $_GET['wins']
            ), "setting");
        }
        else {
            $result = $db->update("setting", array(
                "value" => $_GET['wins']
            ), array(
                "name" => "win_" . $_SESSION['login_username'] . "_pos"
            ));
        }
    break;
	
	case "get_last_window_state":
		$val = $db->select("setting", array( "name" => "win_" . $_SESSION['login_username'] . "_pos" ));
		if(count($val) > 0){
		    $result = json_decode($val[0]['value']);
		}
		else {
		    $result = $val;
		}
	break;
    
    default:
        $result = false;
    break;
}

header('Content-type: application/json');
echo json_encode($result);

@ob_flush();
@flush();