<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
//if(($_FILE['userfile']['type'] == "text/plain") && 
  // ($_FILE['userfile']['size'] < "200000")){
if(eregi('.template',$_FILES['userfile']['name'])){
$file_type=1;
}else{
$file_type=0;
}
if($_FILE['userfile']['size'] < "200000" && $file_type == 1){
	if ($_FILES["userfile"]["error"] > 0){
    	//echo "Return Code: " . $_FILES["userfile"]["error"] . "<br />";
 	$headerurl = "location:commitconf.php?uptemplate_error=1";
	header($headerurl);
    	}else{
	if (file_exists("template/" . $_FILES["userfile"]["name"])){
      		//echo $_FILES["userfile"]["name"] . " already exists. ";
		$headerurl="location:commitconf.php?uptemplate_error=2";
		header($headerurl);
      	}else{
		move_uploaded_file($_FILES["userfile"]["tmp_name"],
      		"template/" . $_FILES["userfile"]["name"]);
      		$template_name=$_FILES["userfile"]["name"];
		$res = $dbconnect->query("insert into templates (template_name, template_type, userid, date) values('".$template_name."', '".$_POST['template_type']."', '".$_SESSION['user_id']."', NOW()) ");
		is_error($res);
		$headerurl = "location:commitconf.php";
		header($headerurl);
      }
    }
  }else{
  $headerurl = "location:commitconf.php?uptemplate_error=3";
  header($headerurl);
 exit;
  }  
?>
