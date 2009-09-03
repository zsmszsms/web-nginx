<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
$domainname=mysql_escape_string($_POST['domainname']);
switch($_REQUEST['active']){
	case "new_service":
		if($_POST['conf_name'] == null || $domainname == null || $_POST['serverip'] ==null){
		header("location: addserivces.php?new_service_error=true");
		break;
		}
		if(addservice($domainname,$_POST['serverip'],$_SESSION['user_id'],$_POST['conf_name'])){
		header('Location: services.php');
		}else{
		header("location: addserivces.php?new_service_error=true");		
		}
		break;
	case "modif_service":
		$res = $dbconnect->query("update services set domain_name='".$domainname."', serverip='".$_POST['serverip']."', status=1 where id=".$_POST['serviceid']);
		is_error($res);
		header('Location: services.php');
		break;
	case "del_service":
		$res = $dbconnect->query("delete from services where id=".$_GET['serviceid']);
		is_error($res);
		$res = $dbconnect->query("delete from upstreams where service_id=".$_GET['serviceid']);
		is_error($res);
		$res = $dbconnect->query("delete from locations where service_id=".$_GET['serviceid']);
		is_error($res);
		$res = $dbconnect->query("delete from rewrites_in_location where service_id=".$_GET['serviceid']);
		is_error($res);
		mail($_CONF['admin_mail'],"nginx_manager:rm ".$_GET['servicename'],"user:".$_SESSION['username']."|rm service".$_GET['servicename']." and serverip ".$_GET['serverip']."!!!");	
		header('Location: delservice.php');
		break;
	default :
		echo"error program.";
}
?>
