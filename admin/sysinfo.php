<?php
/*
修改自iProber v0.024
*/

header("content-Type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ob_start();
 
$valInt = (false == empty($_POST['pInt']))?$_POST['pInt']:"未測試";
$valFloat = (false == empty($_POST['pFloat']))?$_POST['pFloat']:"未測試";
$valIo = (false == empty($_POST['pIo']))?$_POST['pIo']:"未測試";
$mysqlReShow = "none";
$mailReShow = "none";
$funReShow = "none";
$opReShow = "none";
$sysReShow = "none";
 
define("YES", "<span class='resYes'>YES</span>");
define("NO", "<span class='resNo'>NO</span>");
define("ICON", "<span class='icon'>2</span>&nbsp;");
$phpSelf = $_SERVER[PHP_SELF] ? $_SERVER[PHP_SELF] : $_SERVER[SCRIPT_NAME];
define("PHPSELF", preg_replace("/(.{0,}?\/+)/", "", $phpSelf));
 
if ($_GET['act'] == "phpinfo")
{
    phpinfo();
    exit();
}
elseif($_POST['act'] == "TEST_1")
{
    $valInt = test_int();
}
elseif($_POST['act'] == "TEST_2")
{
    $valFloat = test_float();
}
elseif($_POST['act'] == "TEST_3")
{
    $valIo = test_io();
}
elseif($_POST['act'] == "CONNECT")
{
    $mysqlReShow = "show";
    $mysqlRe = "MYSQL連接測試結果：";
    $mysqlRe .= (false !== @mysql_connect($_POST['mysqlHost'], $_POST['mysqlUser'], $_POST['mysqlPassword']))?"MYSQL伺服器連接正常, ":
    "MYSQL伺服器連接失敗, ";
    $mysqlRe .= "資料庫 <b>".$_POST['mysqlDb']."</b> ";
    $mysqlRe .= (false != @mysql_select_db($_POST['mysqlDb']))?"連接正常":
    "連接失敗";
}
elseif($_POST['act'] == "SENDMAIL")
{
    $mailReShow = "show";
    $mailRe = "MAIL郵件發送測試結果：發送";
    $mailRe .= (false !== @mail($_POST["mailReceiver"], "MAIL SERVER TEST", "This email is sent by iProber.\r\n\r\ndEpoch Studio\r\nhttp://depoch.net"))?"完成":"失敗";
}
elseif($_POST['act'] == "FUNCTION_CHECK")
{
    $funReShow = "show";
    $funRe = "函數 <b>".$_POST['funName']."</b> 支持狀況檢測結果：".isfun($_POST['funName']);
}
elseif($_POST['act'] == "CONFIGURATION_CHECK")
{
    $opReShow = "show";
    $opRe = "配置參數 <b>".$_POST['opName']."</b> 檢測結果：".getcon($_POST['opName']);
}
 
 
// 系統參數
 
 
switch (PHP_OS)
{
    case "Linux":
    $sysReShow = (false !== ($sysInfo = sys_linux()))?"show":"none";
    break;
    case "FreeBSD":
    $sysReShow = (false !== ($sysInfo = sys_freebsd()))?"show":"none";
    break;
    default:
    break;
}
     

require '../core/require.php';
include('../database/database.php');

$admincheck=$db->select("user", array("username" => $_SESSION['login_username']));

if($admincheck[0]["admin"] != "true") die("您沒有權限瀏覽設定頁面");

$dockvalue = $db->select("setting", array("name" => "dock"));

if($dockvalue[0]["value"] == "true") $dock = "checked";
else $dock = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ltayer系統資訊</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<style type="text/css">
/*******************************GENERAL**********************************/
body,div,p,ul,form,h1 { margin:0px; padding:0px; }
div,a,input { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #666666; }
div { margin-left:auto; margin-right:auto; }
li { list-style-type:none; }
input { border: 1px solid #999999; background:#f5f5f5; }
a { text-decoration:none; color:#5599ff; }
a.arrow { font-family:Webdings, sans-serif; font-size:10px; }
a.arrow:hover { color:#ff0000; }
.resYes { font-size: 9px; font-weight: bold; color: #33CC00; } 
.resNo { font-size: 9px; font-weight: bold; color: #FF0000; }
.myButton { font-size:10px; font-weight:bold;  background:#CCFFFF; }
.bar { border:1px solid #999999; height:8px; font-size:2px; }
.bar li {  background:#ccffff; height:8px; font-size:2px;}
.jump { height:20px; width:15px; float:right; line-height:10px; text-align:right; }
/*****************************MAIN****************************************/
#main { width:720px; }
#main th { text-align:left; padding:5px 0px; }
#main table { clear:both; }
fieldset {margin-top:15px; margin-bottom:10px; padding:10px; }
legend { background:#5599ff;	color:#FFFFFF; padding:5px 10px; }
fieldset td { border-bottom:1px dotted #dedede; padding:5px 0px; }

#m4 { background-color:#efefef; }
#m4 th,#m4 td { background:#ffffff; padding:3px; border-bottom:none; text-align:center; }
#m4 th { font-weight:normal; color:#444444; }
</style>
</head>
<body>
	<div id="main">
<!-- =============================================================
伺服器特性 
============================================================= -->
		<fieldset>
		<legend>伺服器資訊<a name="sec1" id="sec1"></a></legend>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<?php if("show"==$sysReShow){ ?>
			<tr>
				<td>伺服器處理器 CPU</td>
				<td>CPU個數：
					<?php echo $sysInfo['cpu']['num']; ?>
					<br />
					<?php echo $sysInfo['cpu']['detail']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td>伺服器時間</td>
				<td><?php echo date("Y年n月j日 H:i:s"); ?></td>
			</tr>
			<?php if("show" == $sysReShow){ ?>
			<tr>
				<td>伺服器運行時間</td>
				<td><?php echo $sysInfo['uptime']; ?></td>
			</tr>
			<?}?>
			<tr>
				<td>伺服器域名/IP位址</td>
				<td><?php echo $_SERVER['SERVER_NAME']; ?>
					(
					<?php echo @gethostbyname($_SERVER['SERVER_NAME']); ?>
					)</td>
			</tr>
			<tr>
				<td>伺服器作業系統
					<?$os = explode(" ", php_uname());?></td>
				<td><?php echo $os[0]; ?>
&nbsp;內核版本：
					<?php echo $os[2]; ?></td>
			</tr>
			<tr>
				<td>主機名稱</td>
				<td><?php echo $os[1]; ?></td>
			</tr>
			<tr>
				<td>伺服器引擎</td>
				<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
			</tr>
			<tr>
				<td>硬碟空餘空間</td>
				<td><?php echo round((@disk_free_space(".")/(1024*1024)),2); ?>
					M</td>
			</tr>
			<?php if("show" == $sysReShow){ ?>
			<tr>
				<td>記憶體使用狀況</td>
				<td> 實體記憶體：共
					<?php echo $sysInfo['memTotal']; ?>M, 已使用
					<?php echo $sysInfo['memUsed']; ?>M, 空閒
					<?php echo $sysInfo['memFree']; ?>M, 使用率
					<?php echo $sysInfo['memPercent']; ?>%
					<?php echo bar($sysInfo['memPercent']); ?>
					SWAP區：共
					<?php echo $sysInfo['swapTotal']; ?>M, 已使用
					<?php echo $sysInfo['swapUsed']; ?>M, 空閒
					<?php echo $sysInfo['swapFree']; ?>M, 使用率
					<?php echo $sysInfo['swapPercent']; ?>%
					<?php echo bar($sysInfo['swapPercent']); ?>
				</td>
			</tr>
			<?php } ?>
		</table>
		</fieldset>
<!-- ============================================================= 
PHP基本特性 
============================================================== -->
		<fieldset>
		<legend>PHP基本設定<a name="sec2" id="sec2"></a></legend>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="49%">PHP運行方式</td>
				<td width="51%"><?php echo strtoupper(php_sapi_name()); ?></td>
			</tr>
			<tr>
				<td>PHP版本</td>
				<td><?php echo PHP_VERSION; ?></td>
			</tr>
			<tr>
				<td>安全模式</td>
				<td><?php echo getcon("safe_mode"); ?></td>
			</tr>
			<tr>
				<td>支援ZEND</td>
				<td><?php echo (get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")) ?YES:NO; ?></td>
			</tr>
			<tr>
				<td>允許使用URL打開檔案&nbsp;(allow_url_fopen)</td>
				<td><?php echo getcon("allow_url_fopen"); ?></td>
			</tr>
			<tr>
				<td>允許動態載入程式庫&nbsp;(enable_dl)</td>
				<td><?php echo getcon("enable_dl"); ?></td>
			</tr>
			<tr>
				<td>顯示錯誤資訊&nbsp;(display_errors)</td>
				<td><?php echo getcon("display_errors"); ?></td>
			</tr>
			<tr>
				<td>自動定義總體變數&nbsp;(register_globals)</td>
				<td><?php echo getcon("register_globals"); ?></td>
			</tr>
			<tr>
				<td>最多允許使用記憶體量&nbsp;(memory_limit)</td>
				<td><?php echo getcon("memory_limit"); ?></td>
			</tr>
			<tr>
				<td>POST最大位元組數&nbsp;(post_max_size)</td>
				<td><?php echo getcon("post_max_size"); ?></td>
			</tr>
			<tr>
				<td>允許最大上傳檔&nbsp;(upload_max_filesize)</td>
				<td><?php echo getcon("upload_max_filesize"); ?></td>
			</tr>
			<tr>
				<td>程式執行時間限制&nbsp;(max_execution_time)</td>
				<td><?php echo getcon("max_execution_time"); ?>
					秒</td>
			</tr>
			<tr>
				<td>magic_quotes_gpc</td>
				<td><?php echo (1===get_magic_quotes_gpc())?YES:NO; ?></td>
			</tr>
			<tr>
				<td>magic_quotes_runtime</td>
				<td><?php echo (1===get_magic_quotes_runtime())?YES:NO; ?></td>
			</tr>
			<tr>
				<td>被禁用的函數&nbsp;disable_functions</td>
				<td><?php echo (""==($disFuns=get_cfg_var("disable_functions")))?"無":str_replace(",","<br />",$disFuns); ?></td>
			</tr>
			<tr>
				<td>PHP預設探針&nbsp;PHPINFO</td>
				<td><?php echo (false!==eregi("phpinfo", $disFuns))?NO:"<a href='$phpSelf?act=phpinfo' target='_blank' class='static'>PHPINFO</a>"; ?></td>
			</tr>
		</table>
		</fieldset>
<!-- ============================================================= 
PHP組件支援 
============================================================== -->
		<fieldset>
		<legend>PHP組件支援<a name="sec3" id="sec3"></a></legend>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="38%">拼寫檢查 ASpell Library</td>
				<td width="12%"><?php echo isfun("aspell_check_raw"); ?></td>
				<td width="38%">高精度數學運算 BCMath</td>
				<td width="12%"><?php echo isfun("bcadd"); ?></td>
			</tr>
			<tr>
				<td>曆法運算 Calendar</td>
				<td><?php echo isfun("cal_days_in_month"); ?></td>
				<td>DBA資料庫</td>
				<td><?php echo isfun("dba_close"); ?></td>
			</tr>
			<tr>
				<td>dBase資料庫</td>
				<td><?php echo isfun("dbase_close"); ?></td>
				<td>DBM資料庫</td>
				<td><?php echo isfun("dbmclose"); ?></td>
			</tr>
			<tr>
				<td>FDF表單資料格式</td>
				<td><?php echo isfun("fdf_get_ap"); ?></td>
				<td>FilePro資料庫</td>
				<td><?php echo isfun("filepro_fieldcount"); ?></td>
			</tr>
			<tr>
				<td>Hyperwave資料庫</td>
				<td><?php echo isfun("hw_close"); ?></td>
				<td>圖形處理 GD Library</td>
				<td><?php echo isfun("gd_info"); ?></td>
			</tr>
			<tr>
				<td>IMAP電子郵件系統</td>
				<td><?php echo isfun("imap_close"); ?></td>
				<td>Informix資料庫</td>
				<td><?php echo isfun("ifx_close"); ?></td>
			</tr>
			<tr>
				<td>LDAP目錄協定</td>
				<td><?php echo isfun("ldap_close"); ?></td>
				<td>MCrypt加密處理</td>
				<td><?php echo isfun("mcrypt_cbc"); ?></td>
			</tr>
			<tr>
				<td>哈稀計算 MHash</td>
				<td><?php echo isfun("mhash_count"); ?></td>
				<td>mSQL資料庫</td>
				<td><?php echo isfun("msql_close"); ?></td>
			</tr>
			<tr>
				<td>SQL Server資料庫</td>
				<td><?php echo isfun("mssql_close"); ?></td>
				<td>MySQL資料庫</td>
				<td><?php echo isfun("mysql_close"); ?></td>
			</tr>
			<tr>
				<td>SyBase資料庫</td>
				<td><?php echo isfun("sybase_close"); ?></td>
				<td>Yellow Page系統</td>
				<td><?php echo isfun("yp_match"); ?></td>
			</tr>
			<tr>
				<td>Oracle資料庫</td>
				<td><?php echo isfun("ora_close"); ?></td>
				<td>Oracle 8 資料庫</td>
				<td><?php echo isfun("OCILogOff"); ?></td>
			</tr>
			<tr>
				<td>PREL相容語法 PCRE</td>
				<td><?php echo isfun("preg_match"); ?></td>
				<td>PDF文檔支持</td>
				<td><?php echo isfun("pdf_close"); ?></td>
			</tr>
			<tr>
				<td>Postgre SQL資料庫</td>
				<td><?php echo isfun("pg_close"); ?></td>
				<td>SNMP網路管理協定</td>
				<td><?php echo isfun("snmpget"); ?></td>
			</tr>
			<tr>
				<td>VMailMgr郵件處理</td>
				<td><?php echo isfun("vm_adduser"); ?></td>
				<td>WDDX支持</td>
				<td><?php echo isfun("wddx_add_vars"); ?></td>
			</tr>
			<tr>
				<td>壓縮檔支援(Zlib)</td>
				<td><?php echo isfun("gzclose"); ?></td>
				<td>XML解析</td>
				<td><?php echo isfun("xml_set_object"); ?></td>
			</tr>
			<tr>
				<td>FTP</td>
				<td><?php echo isfun("ftp_login"); ?></td>
				<td>ODBC資料庫連接</td>
				<td><?php echo isfun("odbc_close"); ?></td>
			</tr>
			<tr>
				<td>Session支持</td>
				<td><?php echo isfun("session_start"); ?></td>
				<td>Socket支持</td>
				<td><?php echo isfun("socket_accept"); ?></td>
			</tr>
		</table>
		</fieldset>
		<div><a href="index.php" class="btn btn-info" style="margin-bottom:10px;">回到控制台</a></div>
</body>
</html>
<?php
/*=============================================================
    函數庫
=============================================================*/
/*-------------------------------------------------------------------------------------------------------------
    檢測函數支援
--------------------------------------------------------------------------------------------------------------*/
    function isfun($funName)
    {
        return (false !== function_exists($funName))?YES:NO;
    }
/*-------------------------------------------------------------------------------------------------------------
    檢測PHP設置參數
--------------------------------------------------------------------------------------------------------------*/
    function getcon($varName)
    {
        switch($res = get_cfg_var($varName))
        {
            case 0:
            return NO;
            break;
            case 1:
            return YES;
            break;
            default:
            return $res;
            break;
        }
         
    }
/*-------------------------------------------------------------------------------------------------------------
    整數運算能力測試
--------------------------------------------------------------------------------------------------------------*/
    function test_int()
    {
        $timeStart = gettimeofday();
        for($i = 0; $i < 3000000; $i++);
        {
            $t = 1+1;
        }
        $timeEnd = gettimeofday();
        $time = ($timeEnd["usec"]-$timeStart["usec"])/1000000+$timeEnd["sec"]-$timeStart["sec"];
        $time = round($time, 3)."秒";
        return $time;
    }
/*-------------------------------------------------------------------------------------------------------------
    浮點運算能力測試
--------------------------------------------------------------------------------------------------------------*/
    function test_float()
    {
        $t = pi();
        $timeStart = gettimeofday();
        for($i = 0; $i < 3000000; $i++);
        {
            sqrt($t);
        }
        $timeEnd = gettimeofday();
        $time = ($timeEnd["usec"]-$timeStart["usec"])/1000000+$timeEnd["sec"]-$timeStart["sec"];
        $time = round($time, 3)."秒";
        return $time;
    }
/*-------------------------------------------------------------------------------------------------------------
    資料IO能力測試
--------------------------------------------------------------------------------------------------------------*/
    function test_io()
    {
        $fp = fopen(PHPSELF, "r");
        $timeStart = gettimeofday();
        for($i = 0; $i < 10000; $i++)
        {
            fread($fp, 10240);
            rewind($fp);
        }
        $timeEnd = gettimeofday();
        fclose($fp);
        $time = ($timeEnd["usec"]-$timeStart["usec"])/1000000+$timeEnd["sec"]-$timeStart["sec"];
        $time = round($time, 3)."秒";
        return($time);
    }
/*-------------------------------------------------------------------------------------------------------------
    比例條
--------------------------------------------------------------------------------------------------------------*/
    function bar($percent)
    {
    ?>
<ul class="bar">
	<li style="width:<?php echo $percent; ?>%">&nbsp;</li>
</ul>
<?php
    }
/*-------------------------------------------------------------------------------------------------------------
    系統參數探測 LINUX
--------------------------------------------------------------------------------------------------------------*/
    function sys_linux()
    {
        // CPU
        if (false === ($str = @file("/proc/cpuinfo"))) return false;
        $str = implode("", $str);
        @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(.]+)[\r\n]+/", $str, $model);
        //@preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
        @preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/", $str, $cache);
        if (false !== is_array($model[1]))
            {
            $res['cpu']['num'] = sizeof($model[1]);
            for($i = 0; $i < $res['cpu']['num']; $i++)
            {
                $res['cpu']['detail'][] = "類型：".$model[1][$i]." 緩存：".$cache[1][$i];
            }
            if (false !== is_array($res['cpu']['detail'])) $res['cpu']['detail'] = implode("<br />", $res['cpu']['detail']);
            }
         
         
        // UPTIME
        if (false === ($str = @file("/proc/uptime"))) return false;
        $str = explode(" ", implode("", $str));
        $str = trim($str[0]);
        $min = $str / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) $res['uptime'] = $days."天";
        if ($hours !== 0) $res['uptime'] .= $hours."小時";
        $res['uptime'] .= $min."分鐘";
         
        // MEMORY
        if (false === ($str = @file("/proc/meminfo"))) return false;
        $str = implode("", $str);
        preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
         
        $res['memTotal'] = round($buf[1][0]/1024, 2);
        $res['memFree'] = round($buf[2][0]/1024, 2);
        $res['memUsed'] = ($res['memTotal']-$res['memFree']);
        $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;
         
        $res['swapTotal'] = round($buf[3][0]/1024, 2);
        $res['swapFree'] = round($buf[4][0]/1024, 2);
        $res['swapUsed'] = ($res['swapTotal']-$res['swapFree']);
        $res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;
         
        // LOAD AVG
        if (false === ($str = @file("/proc/loadavg"))) return false;
        $str = explode(" ", implode("", $str));
        $str = array_chunk($str, 3);
        $res['loadAvg'] = implode(" ", $str[0]);
         
        return $res;
    }
/*-------------------------------------------------------------------------------------------------------------
    系統參數探測 FreeBSD
--------------------------------------------------------------------------------------------------------------*/
    function sys_freebsd()
    {
        //CPU
        if (false === ($res['cpu']['num'] = get_key("hw.ncpu"))) return false;
        $res['cpu']['detail'] = get_key("hw.model");
         
        //LOAD AVG
        if (false === ($res['loadAvg'] = get_key("vm.loadavg"))) return false;
        $res['loadAvg'] = str_replace("{", "", $res['loadAvg']);
        $res['loadAvg'] = str_replace("}", "", $res['loadAvg']);
         
        //UPTIME
        if (false === ($buf = get_key("kern.boottime"))) return false;
        $buf = explode(' ', $buf);
        $sys_ticks = time() - intval($buf[3]);
        $min = $sys_ticks / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) $res['uptime'] = $days."天";
        if ($hours !== 0) $res['uptime'] .= $hours."小時";
        $res['uptime'] .= $min."分鐘";
         
        //MEMORY
        if (false === ($buf = get_key("hw.physmem"))) return false;
        $res['memTotal'] = round($buf/1024/1024, 2);
        $buf = explode("\n", do_command("vmstat", ""));
        $buf = explode(" ", trim($buf[2]));
         
        $res['memFree'] = round($buf[5]/1024, 2);
        $res['memUsed'] = ($res['memTotal']-$res['memFree']);
        $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;
		         
        $buf = explode("\n", do_command("swapinfo", "-k"));
        $buf = $buf[1];
        preg_match_all("/([0-9]+)\s+([0-9]+)\s+([0-9]+)/", $buf, $bufArr);
        $res['swapTotal'] = round($bufArr[1][0]/1024, 2);
        $res['swapUsed'] = round($bufArr[2][0]/1024, 2);
        $res['swapFree'] = round($bufArr[3][0]/1024, 2);
        $res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;
         
        return $res;
    }
     
/*-------------------------------------------------------------------------------------------------------------
    取得參數值 FreeBSD
--------------------------------------------------------------------------------------------------------------*/
function get_key($keyName)
    {
        return do_command('sysctl', "-n $keyName");
    }
     
/*-------------------------------------------------------------------------------------------------------------
    確定執行檔位置 FreeBSD
--------------------------------------------------------------------------------------------------------------*/
    function find_command($commandName)
    {
        $path = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');
        foreach($path as $p)
        {
            if (@is_executable("$p/$commandName")) return "$p/$commandName";
        }
        return false;
    }
     
/*-------------------------------------------------------------------------------------------------------------
    執行系統命令 FreeBSD
--------------------------------------------------------------------------------------------------------------*/
    function do_command($commandName, $args)
    {
        $buffer = "";
        if (false === ($command = find_command($commandName))) return false;
        if ($fp = @popen("$command $args", 'r'))
            {
				while (!@feof($fp))
				{
					$buffer .= @fgets($fp, 4096);
				}
				return trim($buffer);
			}
        return false;
    }
?>
