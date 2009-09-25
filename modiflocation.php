<?php
$actionid="configs";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
?>
<div id="content">
	<div id="colOne">
		<h2>Nginx Configs manager</h2>
		<form name="modiflocation" action="config_active.php" method="post">
		<?php
		echo '<table name="listservice">';
                $res = $dbconnect->query("select * from services where id =".$_GET['serviceid']);
                is_error($res);
                $service_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
                echo '<tr><td>serivceid:'.$service_info['id'].'</td></tr>'.
                '<input name="locationserviceid" style="visibility:hidden" value="'.$service_info['id'].'">'.
                '<tr><td>serivceip:'.$service_info['serverip'].'</td></tr>'.
                '<tr><td>serivce:'.$service_info['domain_name'].'</td></tr>';
                echo '</table>'.'<hr/>';
		$locationres = $dbconnect->query("select * from locations where id=".$_GET['id']);
		is_error($res);
		$location_info = $locationres->fetchRow(DB_FETCHMODE_ASSOC);
		echo '<p>nginx location modif:</p>';
		echo '<div id="modiflocation">'.
		'<table name="addlocation">'.
		'<tr>
                <td>location</td>
                <td>alias</td>
                </tr>'.
                '<tr>
                <td><input name="location_path" value="'.$location_info['location_path'].'"></td>
                <td><input name="alias" value="'.$location_info['alias'].'"></td>
                </tr>'.
                '<tr>
                <td>root_path</td>
                <td>proxypass</td>
                </tr>
                <tr>
                <td><input name="root_path" value="'.$location_info['root_path'].'"></td>
                <td><input name="proxypass" value="'.$location_info['proxy_pass'].'"></td>
                </tr>'.
		'<tr><td colspan="2">valid_referers</td></tr>
                        <tr><td colspan="2"><input name="valid_referers" size="40" value="'.$location_info['valid_referers'].'"></td></tr>'.
                '<tr><td colspan="2">proxy_next_upstream</td></tr>
                 <tr><td colspan="2"><input name="proxy_next_upstream" size="40" value="'.$location_info['proxy_next_upstream'].'"></td></tr>
                 <tr><td colspan="2">access_log</td></tr>
                 <tr><td colspan="2"><input name="access_log" size="40" value="'.$location_info['access_log'].'"></td></tr>
                 </table>'.
		'<input style="visibility:hidden" name="serviceid" value="'.$service_info['id'].'">'.
		'<input style="visibility:hidden" name="locationid" value="'.$_GET['id'].'">'.
		'<input style="visibility:hidden" name="active" value="modiflocation">
                 <center><input type="submit" value="update location"></center>
                 </form>';
		?>
	</div>
</div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

