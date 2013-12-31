<?php
if(isset($file[0])){ 
	$data = $file[0];
	
	echo "<div class=\"nav\">";
	echo "<a href='edit.php?id=".$data['id']."'>修改</a>";
	echo "<a href='destory.php?id=".$data['id']."'>刪除</a>";
	echo "<a href='index.php'>返回列表</a>";
	echo "</div>";
?>
	<h1><?php echo $data['name']; ?></h1>
	
	<em>於<?php echo date('Y年m月d日 H時i分', strtotime($data['created_at'])); ?>建立</em>
	<?php if ($data['created_at'] != $data['updated_at']) { ?>
	<br />
	<em>於<?php echo date('Y年m月d日 H時i分', strtotime($data['updated_at'])); ?>更新</em>
	<?php } ?>
	<pre class="prettyprint"><?php echo htmlspecialchars($data['content']); ?>
</pre>
<?php
} else { 
	echo '<em>沒有資料...</em>';
}