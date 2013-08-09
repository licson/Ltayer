<?php
require_once('utils.class.php');
require_once('../../require.php');
require_once('../../database.php');

$rs = $db->select('file',array('user' => $_SESSION['login_username']));
$list = array();
$table = '';

if(is_array($rs)){
	foreach($rs as $file){
		$list[] = array(
			sprintf('<a href="file/%s" class="file-link">%s</a>',$file['real_location'],$file['filename']),
			'檔案',
			Util::formatByteSize(filesize('./file/'.$file['real_location']))
		);
	}
    $table = Util::printTable($list,array('檔案名稱','類型','大小'));
}

$table .= sprintf('<em>%d個檔案。</em>',count($list));

echo strtr(file_get_contents('./view/index.html'),array(
    '{title}' => '主頁',
    '{content}' => $table.'<div id="download" class="modal hide fade" tabindex="-1" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">檔案工作</h3>
        </div>
        <div class="modal-body">
			<p class="lead filename"></p>
			<a class="btn btn-success btn-large download">下載</a>
			<a class="btn btn-danger btn-large delete">刪除</a>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">關閉</button>
        </div>
</div>',
    '{scripts}' => '<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
	$(function(){
		$(\'#download\').modal({show: false});
		$(\'.file-link\').click(function(e){
			e.preventDefault();
			var orig = $(this).text();
			var loc = $(this).attr(\'href\');
			$(\'#download .modal-body .filename\').text($(this).text());
			$(\'#download .modal-body a.download\').attr(\'href\',\'download.php?f=\'+loc+\'&orig=\'+orig);
			$(\'#download .modal-body a.delete\').attr(\'href\',\'delete.php?f=\'+loc+\'&orig=\'+orig);
			$(\'#download\').modal(\'show\');
		});
    });
    </script>'
));