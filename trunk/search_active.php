<?php
$actionid="tools";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}

?>
<div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>Search</h3>
	<form name="search" action="search_active.php" method="post">
	<fieldset style="width:700;height:150;border:1px dashed red">
	<legend style="width:150px;border:1px dashed #ff9966;background-color:#ff0000;text-align:center;font-family:arial;font-weight:bold">Advanced search</legend>
	<table name="search_active">
	<tr>
	<td>ip</td><td><input name="advanced" type="radio"  value="ip" checked="checked"></td>
	</tr>
	<tr>
	<td>domain name</td><td><input name="advanced" value="domain" type="radio"></td>
	</tr>
	<tr>
	<td>rewrite policy</td><td><input name="advanced" value="rewrite" type="radio"></td>
	</tr>
	<tr>
	<td>serarch</td><td><input name="search_active" size="30"></td>
	</tr>
	</table>
	<center><input type="submit" value="search"></center>
	</fieldset>
	</form>
        <hr/>
	<?php
	if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['search_active'] == null){
	echo "<p>waring!! place input search word!</p>";
	echo "</div>";
	include "tools_coltwo.php";
	include "footer.php";
	exit;	
	}
	switch($_POST['advanced']){
		case "ip":
		$ip_info_res = $dbconnect->query("select * from services where serverip like '%".$_POST['search_active']."%'");
		while($ip_info = $ip_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
		echo "<h3>server ip:".$ip_info['serverip']."</h3>". 
		"<ul>".
		"<li>domain_name:<a href='addconfigs.php?serviceid=".$ip_info['id']."'>".$ip_info['domain_name']."</a></li>".
		"</ul>";
		}
		break;
		case "domain":
		$domain_info_res = $dbconnect->query("select * from services where domain_name like '%".$_POST['search_active']."%'");
		while($domain_info = $domain_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
		echo "<h3>domain name:".$domain_info['domain_name']."</h3>".
                "<ul>".
                "<li>domain_name:<a href='addconfigs.php?serviceid=".$domain_info['id']."'>".$domain_info['serverip']."</a></li>".
                "</ul>";
                }
		break;
		case "rewrite":
		$rewrite_info_res = $dbconnect->query("select * from rewrites where comments like '%".$_POST['search_active']."%'");
		while($rewrite_info = $rewrite_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
		echo"<h3>rewrite policy:<a href='rewrite_modif.php?id=".$rewrite_info['id']."'>id:".$rewrite_info['id']."-".$rewrite_info['comments']."</a></h3>";
		}
		$rewrite_method_info_res = $dbconnect->query("select * from rewrites where method like '%".$_POST['search_active']."%'");
		while($rewrite_method_info = $rewrite_method_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
                echo"<h3>rewrite policy:<a href='rewrite_modif.php?id=".$rewrite_method_info['id']."'>id:".$rewrite_method_info['id']."-".$rewrite_method_info['comments']."</a></h3>";
    		}
		break;            
	}
	?>

</div>
<?php
include "tools_coltwo.php";
include "footer.php";
?>
