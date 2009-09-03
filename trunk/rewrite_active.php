<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
switch($_REQUEST["active"]){
	case "addpolicy":
		if($_POST['action'] != null){
		$method_action=$_POST['action']." ";
		}else{
		$method_action="";
		}
	if($_POST['comments']==null){
	$header_info="location: rewrites.php?rewrite_error=1";
	header($header_info);
	break;
	}
	$res = $dbconnect->query("select protasis from rewrites where comments='".$_POST['comments']."'");
	is_error($res);
	if($res->numRows() == 0){
	$add_rewrite_flags=1;
	}else{
	$selected_protasisi = $res->fetchRow();
		if($selected_protasisi[0] == $_POST['protasis']){
		$add_rewrite_flags=1;
		}else{
		$header_info="location: rewrites.php?rewrite_error=2";
		header($header_info);	
		break;
		}
	}
	if($add_rewrite_flags == 1){
	$method = $method_action.$_POST['method']." ".$_POST['flags'];
	$protasis = mysql_escape_string($_POST['protasis']);
	$res = $dbconnect->query("insert into rewrites (protasis, method, comments) values('".$protasis."', '".$method."', '".$_POST['comments']."')");
	is_error($res);
	$header_info="location: rewrites.php";
	header($header_info);
	break;
	}else{
	die("program error add rewrite flags unkown!!");
	}
	case "addrewritetolocation":
		$res = $dbconnect->query("insert into rewrites_in_location (location_id, service_id, comments) values('".$_POST['location_path_id']."', '".$_POST['serviceid']."', '".$_POST['rewrite_policy']."')");
		if(PEAR::isError($res)){
		$header_info="location: addconfigs.php?serviceid=".$_POST['serviceid']."&addrewritetolocation_error=true";
		header($header_info);
		break;	
		}
		upserivce_status(1,$_POST['serviceid']);
		$header_info="location: addconfigs.php?serviceid=".$_POST['serviceid'];
		header($header_info);
        	break;
	case "delrewrite":
		if($_GET['comment'] != null){
		$service_id_res = $dbconnect->query("select service_id from rewrites_in_location where comments='".$_GET['comment']."'");
		is_error($service_id_res);
		$res = $dbconnect->query("delete from rewrites_in_location where comments='".$_GET['comment']."'");
		is_error($res);
		$res = $dbconnect->query("delete from rewrites where comments='".$_GET['comment']."'");
		is_error($res);
		while($service_id = $service_id_res->fetchRow()){
		upserivce_status(1,$service_id[0]);
		}
		$header_info="location: rewrites.php";
        	header($header_info);
		break;
		}
		if($_GET['id'] != null){
		$service_id_res = $dbconnect->query("select service_id from rewrites_in_location where comments='".$_GET['comments']."'");
		is_error($service_id_res);
		$res = $dbconnect->query("delete from rewrites where id=".$_GET['id']);
		is_error($res);
		while($service_id = $service_id_res->fetchRow()){
                upserivce_status(1,$service_id[0]);
                }
		$header_info="location: rewrites.php";
                header($header_info);
		break;
		}
	case "modifrewrite":
		$service_id_res = $dbconnect->query("select service_id from rewrites_in_location where comments='".$_POST['comments']."'");
		is_error($service_id_res);
		$res= $dbconnect->query("select * from rewrites where id=".$_POST['id']);
		is_error($res);
		$select_rewrites_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if($select_rewrites_info['protasis'] == $_POST['protasis']){
		$res = $dbconnect->query("update rewrites set method='".$_POST['method']."' where id=".$_POST['id']);
			if(PEAR::isError($res)){
                	$header_info="location: rewrites.php?rewrite_error=3";
                	header($header_info);
                	break;
                	}else{
			while($service_id = $service_id_res->fetchRow()){
                	upserivce_status(1,$service_id[0]);
                	}
                	$header_info="location: rewrites.php";
                	header($header_info);
               		break;
			}
		}else{
		$res = $dbconnect->query("update rewrites set method='".$_POST['method']."' where id=".$_POST['id']);
		is_error($res);
		$protasis = mysql_escape_string($_POST['protasis']);
		$res = $dbconnect->query("update rewrites set protasis='".$protasis."' where comments='".$select_rewrites_info['comments']."'");
		is_error($res);
		while($service_id = $service_id_res->fetchRow()){
                upserivce_status(1,$service_id[0]);
                }	
		$header_info="location: rewrites.php";
                header($header_info);
                break;
		}
	case "delsrewrite":
		$res = $dbconnect->query("delete from rewrites_in_location where location_id=".$_GET['location_id']." and comments='".$_GET['comments']."'");
		is_error($res);
		upserivce_status(1,$_GET['serviceid']);
		$header_info="location: addconfigs.php?serviceid=".$_GET['serviceid'];
		header($header_info);
                break;
}
?>
