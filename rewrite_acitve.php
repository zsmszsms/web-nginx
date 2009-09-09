<?php
include "functionapi.php";
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
	$res = $dbconnect->query("insert into rewrites (protasis, method, comments) values('".$_POST['protasis']."', '".$method."', '".$_POST['comments']."')");
	is_error($res);
	$header_info="location: rewrites.php";
	header($header_info);
	break;
	}else{
	die("program error!!");
	}
}
?>
