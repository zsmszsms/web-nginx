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
	case "modif_server_ip":
		$res = $dbconnect->query("select domain_name from services where serverip='".$_POST['oldserverip']."'");
		is_error($res);
		$error_info = "";
		$error = 0; 
		while($domain_name=$res->fetchRow()){
		$domain_name_auth=$dbconnect->query("select domain_name from services where serverip='".$_POST['serverip']."' and domain_name='".$domain_name[0]."'");
		if($domain_name_auth->numRows() > 0){
		$error++;
		$error_info .= $_POST['serverip']." and ".$domain_name[0]." in db \r \n";
		}
		}
		if($error > 0){
		mail($_CONF['admin_mail'],"modifserverip","modifserver error info:".$error_info);
		header ('location: nginx_maps.php?maps_active=ip&error=1');
		break;
		}		
		$res = $dbconnect->query("update services set serverip='".$_POST['serverip']."', status=1 where serverip='".$_POST['oldserverip']."'");
		is_error($res);
		mail($_CONF['admin_mail'],"modifserverip","nginx_manager:modif server ip: update service set serverip='".$_POST['serverip']."' where serverip='".$_POST['oldserverip']."'"." \r \n");
		header('Location: nginx_maps.php?maps_active=ip');
		break;
	default :
		echo"error program.";
}
?>
