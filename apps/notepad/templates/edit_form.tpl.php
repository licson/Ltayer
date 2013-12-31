<?php $data = $file[0]; ?>
    <div class="nav">
		<a href="show.php?id=<?php echo $data['id']; ?>">返回</a>
	</div>
	<div id="w_file_name">
		<h1><?php echo $data['name']; ?></h1>
	</div>
	
	<form action="action/edit_action.php" method="post" class="edit-form">
		<label name="title">標題</label>
		<input type="text" name="title" id="new_title" value="<?php echo $data['name']; ?>">
		
        <label name="content">內容</label>		
		<textarea name="content" id="new_content" cols="30" rows="10"><?php echo htmlspecialchars($data['content']); ?></textarea>
		
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
		<button type="submit">儲存</button>
	</form>