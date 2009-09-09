<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Nginx manager</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jsfunction.js"></script>
</head>
<body>
<?if ($actionid == "login"){
echo '<div id="wrapper">
	<div id="header">
                <h1><a href="login.php"><img src="img/nginx-logo.png" /></a></h1>
	</div>';
}else{

echo '<div id="wrapper">
        <div id="header">
                <h1><a href="services.php"><img src="img/nginx-logo.png" alte="nginxlogo" height="60" width="180"></a></h1>
		<h2><a href="search_active.php">search</a>|</a><a href="logout.php">logout</a></h2>
        </div>';
}
?>
        <div id="menu" <?if ($actionid == "login"){echo " style='visibility:hidden'";}else{echo " style='visibility:visibile'";}?>>
                <ul>
                        <li<?if($actionid == "services"){echo " class='active'";}else{echo " class=''";}?>><a href="services.php" accesskey="1" title="">services</a></li>
                        <li<?if($actionid == "configs"){echo " class='active'";}else{echo " class=''";}?>><a href="service_configs.php" accesskey="2" title="">configs</a></li>
                        <li<?if($actionid == "tools"){echo " class='active'";}else{echo " class=''";}?>><a href="modifpw.php" accesskey="3" title="">tools</a></li>
                        <li<?if($actionid == "maps"){echo " class='active'";}else{echo " class=''";}?>><a href="nginx_maps.php?maps_active=ip" accesskey="4" title="">maps</a></li>
                	<li<?if($actionid == "abort"){echo " class='active'";}else{echo " class=''";}?>><a href="web_nginx_abort.php" accesskey="5" title="">abort</a></li>
		</ul>
        </div>

