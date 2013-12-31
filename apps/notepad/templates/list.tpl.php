<?php
switch($action){
	case 'e':
		echo '<h1>選擇要修改的記事</h1>';
	break;
	
	case 'd':
		echo '<h1>選擇要刪除的記事</h1>';
	break;
	
	case 'a':
		echo '<h1>請選擇以下的選項</h1>';
	break;
	
	case 's':
		echo '<div class="nav"><a href="new.php">新增</a></div>';
	break;
	
	default:			
		redirect_to('list.php?a=s');
	break;

}

if(!is_array($file)){
	echo '<em>沒有內容，請用左上方的新增按鈕來新增一個記事本。</em>';
}
else {
?>
<ul class="notes ui-helper-clearfix">
<?php
	foreach($file as $value){			
		if($action == "e") {
			//echo '<h1>Select Note to Edit</h1>';
			echo '<li><p><a href="edit.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>' . PHP_EOL;
		}
		else if($action == "d") {			
			//echo '<h1>Select Note to Delete</h1>';
			echo '<li><p><a href="destory.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>' . PHP_EOL;
		}
		else if($action == "s") {
			//echo '<h1>Select Note to Show</h1>';
			echo '<li><p><a href="show.php?id='.$value['id'].'">'.$value['name'].'</a></p></li>' . PHP_EOL;
		}
		else if($action == "a") {
			echo '<li><p><a href="show.php?id='.$value['id'].'">'.$value['name'].'</a></p><div class="nav nav-noline">'.PHP_EOL;
			echo '<a href="edit.php?id='.$value['id'].'">修改</a>';
			echo '<a href="destory.php?id='.$value['id'].'">銷毀</a></div></li>';
		}
	}
}
?>
</ul>