<?php
switch($action){
	case 'e':
		echo '<h1>Select Note to Edit</h1>';
	break;
	
	case 'd':
		echo '<h1>Select Note to Delete</h1>';
	break;
	
	case 'a':
		echo '<h1>Select a method to continue</h1>';
	break;
	
	case 's':
		echo '<div class="nav"><a href="new.php">Create a new</a></div>';
		echo '<h1>Select Note to Show</h1>';
	break;
	
	default:			
		//echo '<h1>Not any method</h1>';
		redirect_to('list.php?a=s');
	break;

}

if(count($file) == 0){
	echo '<em>No notes.</em>';
}
?>
<ul class="notes ui-helper-clearfix">
<?php
foreach($file as $value){			
	if($action == "e") {
		//echo '<h1>Select Note to Edit</h1>';
		echo '<li><p><a href="edit.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>'.PHP_EOL;
	}
	else if($action == "d") {			
		//echo '<h1>Select Note to Delete</h1>';
		echo '<li><p><a href="destory.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>'.PHP_EOL;
	}
	else if($action == "s") {
		//echo '<h1>Select Note to Show</h1>';
		echo '<li><p><a href="show.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>'.PHP_EOL;
	}
	else if($action == "a") {
		echo '<li><p><a href="show.php?id='.$value['id'].'">'.$value['name'].'</a></p><div class="nav nav-noline">'.PHP_EOL;
		echo '<a href="edit.php?id='.$value['id'].'">Edit</a>';
		echo '<a href="destory.php?id='.$value['id'].'">Destory</a></div></li>';
	}
}
?>
</ul>