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
			<?
			echo '<table name="listupstream">';
			$res = $dbconnect->query("select * from services where id =".$_GET['serviceid']);
			is_error($res);
			$service_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
			echo '<tr><td>serivceid:'.$service_info['id'].'</td></tr>'.
			'<tr><td>serivceip:'.$service_info['serverip'].'</td></tr>'.
			'<tr><td>serivce:'.$service_info['domain_name'].'</td></tr>';		
			echo '</table>'.'<hr/>';
			echo '<p>nginx service config:</p>';
			$config_service_id=$service_info['id'];
			$config_server_name=$service_info['domain_name'];
			?>
			<?php
			$res = $dbconnect->query("select DISTINCT upstream_name from upstreams where service_id=".$_GET['serviceid']);
			is_error($res);
			while($upstreams_name = $res->fetchRow()){
			echo "upstream ".$upstreams_name[0]."{ <br/>";
			$upstream_res = $dbconnect->query("select * from upstreams where service_id=".$_GET['serviceid']." and upstream_name='".$upstreams_name[0]."'");
			is_error($upstream_res);
				while($upstreams_info = $upstream_res->fetchRow(DB_FETCHMODE_ASSOC)){
				echo "server ".$upstreams_info['real_server']."&nbsp;".$upstreams_info['options']." ;";
				echo "<a href='config_active.php?active=delupstream&id=".$upstreams_info['id']."&serviceid=".$config_service_id."'>delete</a><br/>";
				}
			echo "	}<br/>";	
			}
			$locationsres = $dbconnect->query("select * from locations where service_id=".$_GET['serviceid']);
			is_error($locationsres);
			if($locationsres->numRows() > 0){
			echo "server { <br/>";
			echo "listen 80 ; <br/>";
			echo "server_name ".$config_server_name." ;<br/>";
			}
			$locationsum=0;
			while($location_info=$locationsres->fetchRow(DB_FETCHMODE_ASSOC)){
				echo "location ".$location_info['location_path']." { <a href='config_active.php?active=dellocation&id=".$location_info['id']."&locationserviceid=".$config_service_id."'>delete</a><br/>";
				if($location_info['proxy_next_upstream'] != null){
				echo "proxy_next_upstream ".$location_info['proxy_next_upstream']."; <br/>";
				}
				if($location_info['proxy_pass'] != null){
				echo "proxy_pass http://".$location_info['proxy_pass']."; <br/>";
				}
				if($location_info['alias'] != null){
				echo "alias ".$location_info['alias']."; <br/>";
				}
				if($location_info['root_path'] != null){
				echo "root ".$location_info['root_path']."; <br/>";
				}
				if($location_info['access_log'] != null){
				echo "access_log ".$location_info['access_log']."; <br/>";
				}
				echo " }<br/>";
				$locationsum++;	
			}
			if($locationsum > 0){
				echo " }<br/>";	
			}
			?>
			<hr/>
			</div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

