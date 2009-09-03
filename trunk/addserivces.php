<?php
$actionid="services";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
?>
 <div id="content">
 	<div id="colOne">
                        <h2>Nginx Services manager</h2>
			<?
			if($_GET['new_service_error'] == "true"){
			echo"<p>Nginx add error!</p>";
			}
			?>
        		<form name="addservices" action="service_active.php" method="post">
			<table name="newserivces">
			<tr>
			<th>domain name</th>
			<th>server ip</th>
			</tr>
			<tr>
			<td><input name="domainname" size="20"></td>
			<td><input name="serverip" size="20"></td>
			<input style="visibility:hidden" name="active" value="new_service">
			</tr>
			<tr>
			<th>config file name</th>
			</tr>
			<tr>
			<td><input name="conf_name" size="20"></td>
			</tr>
			</table>
			<center><input type="submit" value="new service"></center>
			</form>        	
		</div>
<?php
include "service_coltwo.php";
include "footer.php";
?>

