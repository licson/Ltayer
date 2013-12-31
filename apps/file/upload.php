<?php
require_once('upload.class.php');
require_once('../../core/require.php');

$dir = '/';
if(isset($_GET['d'])){
    $dir = $_GET['d'];
}

$fsdir = Util::getUserDir() . $dir;

if(isset($_FILES['file'])){
    $upload = new Upload('file');
    try {
        $upload->check();
        $upload->move($fsdir);
    }
    catch(Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        die($e->getMessage());
    }
}
else {
    $content = '<p class="lead">檔案上傳</p>
<p>最大檔案大小：' . ini_get('upload_max_filesize') . '</p>
<div class="progress progress-striped" id="status" style="display: none;">
	<div class="progress-bar progress-bar-success" style="width: 0.1%;"></div>
</div>
<form action="upload.php" enctype="multipart/form-data" method="post" id="upload">
	<a href="#" class="btn btn-info btn-sm pull-right" id="add">新增檔案</a>
	<p>
	<input name="file[]" type="file" multiple style="display: block;" />
	</p>
	<p>
	<input type="submit" value="上傳" class="btn btn-success" />
	</p>
</form>';
    
    echo strtr(file_get_contents('./view/index.html'),array(
        '{title}' => '上載',
        '{dir}' => $dir,
		'{side}' => Util::showDirList(Util::listDirOnly(Util::getUserDir())),
        '{content}' => $content,
        '{scripts}' => '<style>
</style><script>
$(function(){
	$(\'#add\').click(function(e){
		e.preventDefault();
		$(this).parent().prepend(\'<input name="file[]" type="file" multiple style="display: block;" />\');
	});
	
	$(\'.tree-indicator\').click(function(){
		var $state = $(this).html();
		$(this).parent().find(\'ul.dir-tree\').slideToggle(500);
		$(this).text($state == \'+\' ? \'-\' : \'+\');
	});
	
	if(typeof FormData !== "undefined"){
		$(\'#upload\').submit(function(e){
			e.preventDefault();
			var xhr = new XMLHttpRequest();
			xhr.onload = function(){
				if(xhr.status == 200){
					alert("上傳完成");
				}
				else {
					alert("上傳錯誤: " + xhr.response);
				}
			};
			xhr.upload.onprogress = function(e){
				$(\'#status\').show();
				if(e.lengthComputable){
					$(\'#status .progress-bar\').css({
						width: (e.loaded / e.total) * 100 + \'%\'
					});
				}
				else {
					$(\'#status\').addClass(\'active\');
					$(\'#status .progress-bar\').css({
						width: \'100%\'
					});
				}
			}
			xhr.open("POST","upload.php?d=' . $dir . '",true);
			xhr.send(new FormData($(\'#upload\').get(0)));
		});
	}
});
</script>'
    ));
}