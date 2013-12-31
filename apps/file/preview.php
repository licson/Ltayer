<?php
require_once('../../core/require.php');
require_once('utils.class.php');
require_once('preview.class.php');

if(!isset($_GET['f'])){
	die();
}

$preview = new Preview($_GET['f']);

echo strtr(file_get_contents('./view/index.html'),array(
	'{title}' => '預覽',
	'{dir}' => '/',
	'{side}' => Util::showDirList(Util::listDirOnly(Util::getUserDir())),
	'{content}' => '<p class="lead">預覽</p>' . $preview->renderHTML(),
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