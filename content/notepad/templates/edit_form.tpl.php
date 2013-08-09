    <div class="nav">
		<a href="show.php?id=<?php echo $file['id']; ?>">Back to note</a>
	</div>
	<div id="w_file_name">
		<h1><?php echo $file['name']; ?></h1>
	</div>
	
	<form action="action/edit_action.php" method="post" class="edit-form">
		<label name="title">File Name:</label>
		<input type="text" name="title" id="new_title" value="<?php echo $file['name']; ?>">
		
        <label name="content">Content:</label>		
		<textarea name="content" id="new_content" cols="30" rows="10"><?php echo htmlspecialchars($file['content']); ?></textarea>
		
        <input type="hidden" name="id" value="<?php echo $file['id']; ?>">
		<button type="submit">Save</button>
	</form>