<?php
  //取得表單資料
  $from_name = "=?utf-8?B?" . base64_encode($_POST["from_name"]) . "?=";
  $from_email = $_POST["from_email"];	
  $to_name = "=?utf-8?B?" . base64_encode($_POST["to_name"]) . "?=";
  $to_email = $_POST["to_email"];	
  $format = $_POST["format"];
  $subject = "=?utf-8?B?" . base64_encode($_POST["subject"]) . "?=";
  $message = $_POST["message"];
	
  //建立 MIME 邊界字串
  $mime_boundary = md5(uniqid(mt_rand(), TRUE));
	
  //建立郵件標頭資訊
  $header  = "From: $from_name<$from_email>\r\n";
  $header .= "To: $to_name<$to_email>\r\n";
  $header .= "MIME-Version: 1.0\r\n";
  $header .= "Content-Type: multipart/mixed; boundary=". $mime_boundary . "\r\n";
	
  //建立郵件內容
  $content  = "This is a multi-part message in MIME format.\r\n";
  $content .= "--$mime_boundary\r\n";
  $content .= "Content-Type: text/$format; charset=utf-8\r\n";
  $content .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
  $content .= "$message\r\n";
  $content .= "--$mime_boundary\r\n";		
	
  //若檔名稱不是空白，表示上傳成功，新增附加檔案
  if ($_FILES{"myfile"}{"name"} != "")
  {
    $file = $_FILES{"myfile"}{"tmp_name"};
    $file_name = $_FILES{"myfile"}{"name"};
    $content_type = $_FILES{"myfile"}{"type"};
		
    //開啟檔案
    $fp = fopen($file, "rb");
		
    //讀取檔案內容
    $data = fread($fp, filesize($file));
		
    //使用 MIME base64 來對 $data 編碼
    $data = chunk_split(base64_encode($data));
		
    //加入附加檔案	
    $content .= "Content-Type: $content_type; name=$file_name\r\n"; 
    $content .= "Content-Disposition: attachment; filename=$file_name\r\n";		
    $content .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $content .= "$data\r\n";
    $content .= "--$mime_boundary--\r\n";
  } 

  //傳送郵件
  mail($to_email, $subject, $content, $header);
  echo "郵件已經寄出";
?>