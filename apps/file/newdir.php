<?php
require_once('utils.class.php');
require_once('../../core/require.php');

$dir = '/';
if(isset($_GET['d'])){
    $dir = $_GET['d'];
}

$fsdir = Util::getUserDir() . $dir;

if(isset($_POST['dir'])){
	$status = @mkdir($fsdir . '/' . trim($_POST['dir'], "/\\"));
	$content = '<p class="lead">新增資料夾</p>' . 
	($status ? '<div class="alert alert-success">新增完成</div>' : '<div class="alert alert-danger">建立資料夾失敗</div>') .
	'<form action="newdir.php?d=' . $dir . '" method="post">
	<label for="dir">資料夾名稱</label>
	<p>
	<input type="text" name="dir" id="dir" class="form-control" />
	</p>
	<p>
	<input type="submit" value="新增" class="btn btn-success btn-large" />
	</p>
</form>';
}
else {
    $content = '<p class="lead">新增資料夾</p>
<form action="newdir.php?d=' . $dir . '" method="post">
	<label for="dir">資料夾名稱</label>
	<p>
	<input type="text" name="dir" id="dir" class="form-control" />
	</p>
	<p>
	<input type="submit" value="新增" class="btn btn-success btn-large" />
	</p>
</form>';
}

echo strtr(file_get_contents('./view/index.html'),array(
	'{title}' => '新增資料夾',
	'{dir}' => $dir,
	'{side}' => Util::showDirList(Util::listDirOnly(Util::getUserDir())),
	'{content}' => $content,
	'{scripts}' => '<style>
</style><script>
$(function(){
	$(\'.tree-indicator\').click(function(){
		var $state = $(this).html();
		$(this).parent().find(\'ul.dir-tree\').slideToggle(500);
		$(this).text($state == \'+\' ? \'-\' : \'+\');
	});
});
</script>'
));