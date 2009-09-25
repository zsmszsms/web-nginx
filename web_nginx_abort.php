<?php
$actionid="abort";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
?>
<div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>Abort</h3>
        <hr/>
	<p>web-nginx <?=$version?></p> 
	<p>web-nginx 配置管理程序</p>
	本程序用于管理nginx 服务器的配置管理，适用于nginx的http代理服务配置和http服务配置。
	程序为提高多台nginx 服务器集中化管理和配置文件统一性所设计。
	如对本程序有改进见意，欢迎与我联系。
</div>
<?php
include "abort_coltwo.php";
include "footer.php";
?>

