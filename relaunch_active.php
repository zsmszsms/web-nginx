<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
switch($_GET['active']){
	case "serviceip":
	$res=$dbconnect->query("update services set status=1 where serverip='".$_GET['ip']."'");
	is_error($res);
	$header_info="Location: commitconf.php";
	header($header_info);
	break;
	case "servicedomain":
	$res=$dbconnect->query("update services set status=1 where id=".$_GET['domain']);
	is_error($res);
	$header_info="Location: commitconf.php";
        header($header_info);
        break;

}
?>
