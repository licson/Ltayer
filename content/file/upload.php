<?php
require_once('upload.class.php');
require_once('../../require.php');
require_once('../../database.php');

if(isset($_FILES['file'])){
    $upload = new Upload('file');
    try {
        $upload->check();
        $upload->move('./file/');
		foreach($upload->files as $file){
			$db->insert(array(
				"filename" => $file['name'],
				"real_location" => $file['real_name'],
				"user" => $_SESSION['login_username']
			),"file");
		}
    }
    catch(Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        die($e->getMessage());
    }
}
else {
    $content = '<p class="lead">檔案上傳</p>
    <p>最大檔案大小：'.ini_get('upload_max_filesize').'</p>
    <div class="progress progress-striped" id="status" style="display: none;">
        <div class="bar" style="width: 0.1%;"></div>
    </div>
    <form action="upload.php" enctype="multipart/form-data" method="post" id="upload">
        <a href="#" class="btn pull-right" id="add">新增檔案</a>
        <input name="file[]" type="file" style="display: block;" />
        <input type="submit" value="上傳" class="btn btn-large"/>
    </form>';
    
    echo strtr(file_get_contents('./view/index.html'),array(
        '{title}' => '主頁',
        '{content}' => $content,
        '{scripts}' => '<script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
        $(function(){
            $(\'#add\').click(function(e){
                e.preventDefault();
                $(this).parent().prepend(\'<input name="file[]" type="file" style="display: block;" />\');
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
                            alert("上傳錯誤");
                        }
                    };
                    xhr.upload.onprogress = function(e){
                        $(\'#status\').show();
                        if(e.lengthComputable){
                            $(\'#status .bar\').css({
                                width: (e.loaded / e.total) * 100 + \'%\'
                            });
                        }
                        else {
                            $(\'#status\').addClass(\'active\');
                            $(\'#status .bar\').css({
                                width: \'100%\'
                            });
                        }
                    }
                    xhr.open("POST","upload.php",true);
                    xhr.send(new FormData($(\'#upload\').get(0)));
                });
            }
        });
        </script>'
    ));
}