<?php
$actionid="maps";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
?>
 <div id="content">
        <div id="colOne">
                        <h2>Nginx Services manager</h2>
			<h3>Nginx Server modif</h3>
			<p>if modif server,then all service modif!!</p>
			<form name="modif_server_ip" action="service_active.php" method="post">
			<table name="modifserverip">
			<tr>
			<td><input name="serverip" value="<?=$_GET['serverip']?>" size="30"></td></tr>
			<tr><td><input style="visibility:hidden" name="active" value="modif_server_ip"></td></tr>
			<tr><td><input style="visibility:hidden" name="oldserverip" value="<?=$_GET['serverip']?>"></td></tr>
			<tr><td><input type="submit" value="modif ip"></td>
			</tr>
			</table>
			</form>
</div>
<?php
include "maps_coltwo.php";
include "footer.php";
?>

