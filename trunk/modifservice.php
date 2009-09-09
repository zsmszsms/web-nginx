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
		<form action="service_active.php" method="post">
		<?php
		$res = $dbconnect->query("select * from services where id=".$_GET['id']);
		is_error($res);
		$service_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
		echo "<table name='modifservice'>".
		"<tr>".
		"<td>domain name</td>".
		"<td>server ip</td>".
		"</tr>";
		echo "<tr>".
		"<td><input name='domain_name' value='".$service_info['domain_name']."'></td>".
		"<td><input name='serverip' value='".$service_info['serverip']."'></td>";
		echo "</table>".
		"<input name='serviceid' style='visibility:hidden' value='".$_GET['id']."'>".
		"<input name='active' style='visibility:hidden' value='modif_service'".
		"<center><input type='submit' value='update service'></center>";
		?>
		</form>
	</div>		


  <div id="colTwo">
                        <h2>Nginx Services</h2>
                        <h3>Service Changes</h3>
                        <ul>
                                <li><a href="addserivces.php">Add Nginx Service</a></li>
                                <li><a href="delservice.php">Del Nginx Service</a></li>
                        </ul>
                        <h3>Help Information</h3>
                        <p> nginx services in manager!!</p>
                </div>
                <div style="clear: both;">&nbsp;</div>
        </div>
<?php
include "footer.php";
?>


