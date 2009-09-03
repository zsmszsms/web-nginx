<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
switch ($_REQUEST['active']){
	case "adduser":
	if($_POST['username'] != null || $_POST['password'] != null){
	$res = $dbconnect->query("insert into users (username, password, admin) values('".$_POST['username']."', md5('".$_POST['password']."'), '".$_POST['admin']."')");
		if(PEAR::isError($res)){
		header('Location: useradd.php?adduser_error=true');
		}else{	
		header('Location: useradd.php');
		}
	}else{
	header('Location: useradd.php?adduser_error=true');
	}
	break;
	case "deluser":
	$res = $dbconnect->query("update services set userid = 1 where userid=".$_GET['id']);
	is_error($res);
	$res = $dbconnect->query("delete from users where id=".$_GET['id']);
	  if(PEAR::isError($res)){
                header('Location: userdel.php?deluser_error=true');
                }else{
                header('Location: userdel.php');
                }
	break;
	case "restpw":
	$authpw=authpasswd(8);
	$res = $dbconnect->query("update users set password=md5('".$authpw."') where id=".$_GET['id']);
	is_error($res);
	$subject="web_nginx user password rest report";
	$mail_content="web_nginx user password rest report \r \n".
		      "=================================== \r \n".
		      "newpassword: ".$authpw."\r \n";
	$headers="From: web-nginx admin <".$_CONF['admin_mail'].">";
	mail($_CONF['admin_mail'], $subject, $mail_content, $headers);
	header('Location: useradd.php');
	break;
	case "modifpw":
	$res=$dbconnect->query("select * from users where username='".$_POST['username']."' and password=md5('".$_POST['oldpassword']."')");
	is_error($res);
	if($res->numRows() == 1 && $_POST['newpassword'] == $_POST['replaypassword']){
	$res=$dbconnect->query("update users set password=md5('".$_POST['newpassword']."') where username='".$_POST['username']."'");
	is_error($res);
	header('Location: modifpw.php');
	}else{
	header('Location: modifpw.php?modifpw_error=1');
	}
	break;
	default:
        die("program error!!");

}
?>
