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
			if($_GET['addupstream_error'] == "true"){
			echo"<p>add upstream error!!</p>";
			}
			if($_GET['addlocation_error'] == "true"){
			echo"<p>add location error!!</p>";
			}
			if($_GET['addrewritetolocation_error'] == "true"){
			echo"<p>add rewrite to location error!!</p>";
			}
			?>
			<form name="newconfig" action="config_active.php" method="post">
			<?
			echo '<table name="listupstream">';
			$res = $dbconnect->query("select * from services where id =".$_GET['serviceid']);
			is_error($res);
			$service_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
			echo '<tr><td>serivceid:'.$service_info['id'].'</td></tr>'.
			'<input name="serviceid" style="visibility:hidden" value="'.$service_info['id'].'">'.
			'<tr><td>serivceip:'.$service_info['serverip'].'</td></tr>'.
			'<tr><td>serivce:'.$service_info['domain_name'].'</td></tr>'.
			'<tr><td>config name:'.$service_info['conf_name'].'</td></tr>';		
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
				echo "location ".$location_info['location_path']." { <a href='modiflocation.php?id=".$location_info['id']."&serviceid=".$config_service_id."'>edit location</a><br/>";
				if($location_info['valid_referers'] !=null){
				echo "valid_referers ".$location_info['valid_referers'].";<br/>";
				}
				$rewrites_info_res = $dbconnect->query("select comments from rewrites_in_location where location_id=".$location_info['id']);
				is_error($rewrites_info_res);
				if($rewrites_info_res > 0){
					//$rewrite_policy_contect="";
					$rewrite_policy_protasis="";
					while ($rewrites_info = $rewrites_info_res->fetchRow()){
					$rewritessum =1;
					$rewrite_policy_info_res = $dbconnect->query("select * from rewrites where comments='".$rewrites_info[0]."'");
					is_error($rewrite_policy_info_res);
						while($rewrite_policy_info = $rewrite_policy_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
						$rewrite_policy_contect.=$rewrite_policy_info['method'].";<a href='rewrite_active.php?active=delsrewrite&comments=".$rewrite_policy_info['comments']."&serviceid=".$_GET['serviceid']."&location_id=".$location_info['id']."'>delete rewrite</a><br />";
						$rewrite_policy_protasis=$rewrite_policy_info['protasis'];
						}
						if($rewrite_policy_protasis == null){
                                        	echo $rewrite_policy_contect;
                                       		}else{
                                        	echo "if(".$rewrite_policy_protasis.") {<br />".
                                        	$rewrite_policy_contect.
                                        	"}<br/>";
                                        	}
						$rewrite_policy_contect="";

					}
				}
				//echo "location ".$location_info['location_path']." { <a href='modiflocation.php?id=".$location_info['id']."&serviceid=".$config_service_id."'>edit location</a><br/>";
			/*	if($rewritessum == 1){
					if($rewrite_policy_protasis == null){
					echo $rewrite_policy_contect;
					}else{
					echo "if(".$rewrite_policy_protasis.") {<br />".
                       	 		$rewrite_policy_contect.
                        		"}<br/>";
					}
				}*/
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
			<p>nginx upstream add:</p>
			<a href="#" onclick="showElement('addupstream')">show control</a>
			<div id="addupstream">
			<table name="addupstream">
			<tr>
			<td>upstreams<input name="upstream_name"></td>
			<td>options<input name="options" size="10"></td>
			</tr>
			<tr>
			<td>realserver<input name="real_server"></td>
			</tr>
                        </table>
			<?echo '<input name="locationservicedomain" style="visibility:hidden" value="'.$config_server_name.'">';
			echo '<input name="locationserviceid" style="visibility:hidden" value="'.$config_service_id.'">';
			?>
			<input style="visibility:hidden" name="active" value="newupstream">
			<center><input type="submit" value="add upstream"></center>
                        </form>
			</div>
			<hr/>
			<p>nginx location add:</p>
			<a href="#" onclick="showElement('addlocation')">show control</a>
			<div id="addlocation">
			<form name="newlocation" action="config_active.php" method="post">
			<?php echo '<input name="locationserviceid" style="visibility:hidden" value="'.$config_service_id.'">';
			?>
			<table name="addlocation">
			<tr>
			<td>location</td>
			<td>alias</td>
			</tr>
			<tr>
			<td><input name="location_path"></td>
			<td><input name="alias"></td>
			</tr>
			 <tr>
                        <td>root_path</td>
                        <td>proxypass</td>
                        </tr>
			<tr>
			 <td><input name="root_path"></td>
                        <td><input name="proxypass"></td>
			</tr>
			<tr><td colspan="2">valid_referers</td></tr>
			<tr><td colspan="2"><input name="valid_referers" size="40"></td></tr>
			<tr><td colspan="2">proxy_next_upstream</td></tr>
			<tr><td colspan="2"><input name="proxy_next_upstream" size="40"></td></tr>
			<tr><td colspan="2">access_log</td></tr>
                        <tr><td colspan="2"><input name="access_log" size="40"></td></tr>
			</table>
			<input style="visibility:hidden" name="active" value="addlocation">
			<center><input type="submit" value="add location"></center>
                        </form>
			</div>
			<hr/>
			<p>nginx rewrite add:</p>
			<a href="#" onclick="showElement('addrewrite')">show control</a>
			<div id="addrewrite">
			<form name="addrewrite" action="rewrite_active.php" method="post">
			<table name="addrewrite">
			<?php
                        $res = $dbconnect->query("select DISTINCT comments from rewrites");
                        is_error($res);
                        echo"<tr>".
                        "<td>rewrite_policy:</td>".
                        "<td><select name='rewrite_policy'>";
                        while($commits_name = $res->fetchRow()){
                        echo"<option value='".$commits_name[0]."'>".$commits_name[0]."</option>";
                        }
			echo"</select>".
                        "</tr>";
			$res = $dbconnect->query("select id, location_path from locations where service_id=".$_GET['serviceid']);
			is_error($res);
			echo "<tr>".
			"<td>location_path:</td>".
			"<td><select name='location_path_id'>";
			while($location_id_name = $res->fetchRow()){
			echo"<option value='".$location_id_name[0]."'>".$location_id_name[1]."</option>";
			}
			echo "</select>".
			"</tr>";	
                        ?>
			</table>
			<?php
			echo '<input style="visibility:hidden" name="serviceid" value="'.$_GET['serviceid'].'">';
			?>
			<input style="visibility:hidden" name="active" value="addrewritetolocation">
			<center><input type="submit" value="add rewrite"></center>	
			</form>
			</div>
                </div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

