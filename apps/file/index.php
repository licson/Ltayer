<?php
require_once('utils.class.php');
require_once('../../core/require.php');
$dir = '/';

if(isset($_GET['d'])){
	$dir = $_GET['d'];
}

$fsdir = Util::getUserDir() . $dir;

if(!is_dir($fsdir)){
	@mkdir($fsdir);
}

$list = Util::listDir($fsdir);
if(count($list) !== 0){
	$table = Util::printTable($list, array('路徑', '類型', '大小'));
}
else {
	$table = '<div class="alert alert-info">沒有檔案!</div>';
}

echo strtr(file_get_contents('./view/index.html'),array(
	'{title}' => '主頁',
	'{dir}' => $dir,
	'{side}' => Util::showDirList(Util::listDirOnly(Util::getUserDir())),
	'{content}' => $table . '<div id="download" class="modal fade" tabindex="-1" >
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>檔案工作</h3>
	</div>
	<div class="modal-body">
		<p class="lead filename"></p>
		<a class="btn btn-success btn-large download">下載</a>
		<a class="btn btn-warning btn-large preview">預覽</a>
		<a class="btn btn-danger btn-large delete">刪除</a>
	</div>
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">關閉</button>
	</div>
	</div>
	</div>
</div>
<div id="dir" class="modal fade" tabindex="-1" >
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>資料夾工作</h3>
	</div>
	<div class="modal-body">
		<p class="lead filename"></p>
		<a class="btn btn-success btn-large browse">瀏覽</a>
		<a class="btn btn-danger btn-large delete-dir">刪除</a>
	</div>
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">關閉</button>
	</div>
	</div>
	</div>
</div>',
	'{scripts}' => '<style>

</style><script>
$(function(){
	$(\'#download, #dir\').modal({show: false});
	$(\'.file-link:not([data-is-dir=1])\').click(function(e){
		e.preventDefault();
		var loc = $(this).attr(\'data-filename\');
		$(\'#download .modal-body .filename\').text($(this).text());
		$(\'#download .modal-body a.download\').attr(\'href\',\'download.php?f=\' + WorkingDir + \'/\' + loc);
		$(\'#download .modal-body a.delete\').attr(\'href\',\'delete.php?f=\' + WorkingDir + \'/\' + loc);
		
		if($(this).attr(\'data-previeable\') == "1"){
			$(\'#download .modal-body a.preview\').attr(\'href\',\'preview.php?f=\' + WorkingDir + \'/\' + loc);
		}
		else {
			$(\'#download .modal-body a.preview\').hide();
		}
		
		$(\'#download\').modal(\'show\');
	});
	
	$.contextMenu({
		selector: \'.file-link[data-is-dir=0]\',
        callback: function(key, opts){
            var trigger = opts.$trigger;
            var loc = trigger.attr(\'data-filename\');
            switch(key){
                case "download":
                window.location.href = \'download.php?f=\' + WorkingDir + \'/\' + loc;
                break;
                
                case "preview":
                if(trigger.attr(\'data-previeable\') == "1"){
                    window.location.href = \'preview.php?f=\' + WorkingDir + \'/\' + loc;
                }
                break;
                
                case "delete":
                window.location.href = \'delete.php?f=\' + WorkingDir + \'/\' + loc;
                break;
            }
        },
	    items: {
            download: {
                name: "下載"
            },
            preview: {
                name: "預覽"
            },
            delete: {
                name: "刪除"
            }
        }
    });
    
	$.contextMenu({
		selector: \'.file-link[data-is-dir=1]\',
        callback: function(key, opts){
            var trigger = opts.$trigger;
            var loc = trigger.attr(\'href\');
            switch(key){
                case "download":
                window.location.href = \'index.php\' + loc;
                break;
                
                case "delete":
                window.location.href = \'delete.php\' + loc;
                break;
            }
        },
	    items: {
            browse: {
                name: "檢視資料夾"
            },
            delete: {
                name: "刪除"
            }
        }
    });
	
	$(\'.tree-indicator\').click(function(){
		var $state = $(this).html();
		$(this).parent().find(\'ul.dir-tree\').slideToggle(500);
		$(this).html($state == \'<i class="ion-ios7-plus-empty"></i>\' ? \'<i class="ion-ios7-minus-empty"></i>\' : \'<i class="ion-ios7-plus-empty"></i>\');
	});
});
</script>'
));