<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
switch($_REQUEST['active']){
	case "newconfig":
	$addconfig_header="location: addconfigs.php?serviceid=".$_REQUEST['serviceid'];
	header($addconfig_header);
	break;
	case "modifconfig":
        $addconfig_header="location: addconfigs.php?serviceid=".$_REQUEST['serviceid'];
        header($addconfig_header);
        break;
	case "newupstream";
	/*
	if(isset($_POST['ip_hash'])){
	$ip_hash=1;
	}else{
	$ip_hash=0;	
	}
	*/
	$res = $dbconnect->query("insert into upstreams (upstream_name, real_server, options, service_id) values('sid".$_POST['locationserviceid']."-".$_POST['upstream_name']."', '".$_POST['real_server']."', '".$_POST['options']."', ".$_POST['serviceid'].")");
	if(PEAR::isError($res)){
	$addconfig_header="location: addconfigs.php?serviceid=".$_POST['serviceid']."&addupstream_error=true";
	}else{
	$addconfig_header="location: addconfigs.php?serviceid=".$_POST['serviceid'];
	}
	$status=1;
	if(upserivce_status($status,$_POST['serviceid'])){
	header($addconfig_header);
	}else{
	die("update service status error!! service id".$_POST['serviceid']);
	}
	break;
	case "addlocation":
	$location_path=mysql_escape_string($_POST['location_path']);
	$res = $dbconnect->query("insert into locations (location_path, alias, root_path, proxy_pass, proxy_next_upstream, access_log, service_id) values('".$location_path."', '".$_POST['alias']."', '".$_POST['root_path']."', '".$_POST['proxypass']."', '".$_POST['proxy_next_upstream']."', '".$_POST['access_log']."', ".$_POST['locationserviceid'].")");
	if(PEAR::isError($res)){
        $addconfig_header="location: addconfigs.php?serviceid=".$_POST['locationserviceid']."&addlocation_error=true";
        }else{
        $addconfig_header="location: addconfigs.php?serviceid=".$_POST['locationserviceid'];
        }
	$status=1;
	if(upserivce_status($status,$_POST['locationserviceid'])){
        header($addconfig_header);
        }else{
        die("update service status error!! service id".$_POST['locationserviceid']);
        }
        break;
	case "delupstream":
	$res = $dbconnect->query("delete from upstreams where id=".$_GET['id']);
	is_error($res);
	$addconfig_header="location: addconfigs.php?serviceid=".$_REQUEST['serviceid'];
        $status=1;
        if(upserivce_status($status,$_REQUEST['serviceid'])){
        header($addconfig_header);
        }else{
        die("update service status error!! service id".$_POST['serviceid']);
        }
	break;
	case "modiflocation":
	$location_path=mysql_escape_string($_POST['location_path']);
	$res = $dbconnect->query("update locations set location_path='".$location_path."', alias='".$_POST['alias']."', root_path='".$_POST['root_path']."', proxy_pass='".$_POST['proxypass']."', proxy_next_upstream='".$_POST['proxy_next_upstream']."', access_log='".$_POST['access_log']."' where id=".$_POST['locationid']);
	is_error($res);
	$status=1;
        if(upserivce_status($status,$_REQUEST['serviceid'])){
        $addconfig_header="location: addconfigs.php?serviceid=".$_REQUEST['serviceid'];
	header($addconfig_header);
        }else{
        die("update service status error!! service id".$_POST['serviceid']);
        }
        break;
	case "dellocation":
	$res = $dbconnect->query("delete from locations where id=".$_GET['id']);
	is_error($res);
        $addconfig_header="location: addconfigs.php?serviceid=".$_REQUEST['locationserviceid'];
        header($addconfig_header);
	default:
	echo "program error!";
	break;	
}
?>
