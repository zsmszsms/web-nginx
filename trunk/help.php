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
        <h3>Help v1.0</h3>
	<hr/>
	<p>building ...</p>
	<p>web-nginx<?=$version?></p>
	<p>web-nginx<?=$version?>版本中用于管理http代理\http服务。</p>
        <ul>
	<li>services 模块</li>
	<p>service 用于管理nginx中的服务。在web-nginx中定义所有域名为一个service,可以在不同的nginx主机中创建相同的serivce，用于南北服务器或分布式设计。</p>
		<ul>
		<li>增加服务</li>
		<li>删除服务</li>
		<li>客户错误日志</li>
		</ul>
	<li>configs 模块</li>
	<p>configs 用于配置nginx service的内容。支持不同的模板定义，web-nginx使用专用指令写入配置文件。</p>
		<ul>
		<li>修改配置</li>
		<li>删除配置</li>
		<li>提交配置</li>
		</ul>
	</ul>
</div>
<?php
include "abort_coltwo.php";
include "footer.php";
?>
