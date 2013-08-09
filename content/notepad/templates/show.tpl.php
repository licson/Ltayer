<?php
if(isset($file['id'])){ 
	echo "<div class=\"nav\">";
	echo "<a href='edit.php?id=".$file['id']."'>Edit Note</a>";
	echo "<a href='destory.php?id=".$file['id']."'>Destory Note</a>";
	echo "<a href='index.php'>Back to list</a>";
	echo "</div>";
?>
	<h1><?php echo $file['name']; ?></h1>
	
	<em>Created at <?php echo $file['created_at']; ?></em>
	<?php if ($file['created_at'] != $file['updated_at']) { ?>
	<br />
	<em>Updated at <?php echo $file['updated_at']; ?></em>
	<?php } ?>
	<pre class="prettyprint"><?php echo htmlspecialchars($file['content']); ?>
</pre>
<?php }
else { 
	echo 'No Data';
}
?>