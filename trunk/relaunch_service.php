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
                        <h2>Nginx Configs manager</h2>
			<h3>relaunch<h3>
			<hr>
			<?php
			if($_SESSION['user_class'] == "admin"){
			 $service_serverip_res = $dbconnect->query("select DISTINCT serverip from services");
	                is_error($service_serverip_res);
        	        if($service_serverip_res->numRows() == 0){
                	die("not service in web-nginx !!");
                	}
                	while($service_serverip = $service_serverip_res->fetchRow()){
                	echo '<a href="#" onclick="showElement(\''.$service_serverip[0].'\')">show: '.$service_serverip[0].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="relaunch_active.php?active=serviceip&ip='.$service_serverip[0].'">relaunch host</a>'.
                	'<div id="'.$service_serverip[0].'" style="display:none">';
                	$service_domain_name_res = $dbconnect->query("select id,domain_name from services where serverip='".$service_serverip[0]."'");
                	is_error($service_domain_name_res);
                        echo "<ul>";
                        while($service_domain_name = $service_domain_name_res->fetchRow()){
                        echo "<li><a href='addconfigs.php?serviceid=".$service_domain_name[0]."'>$service_domain_name[1]</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='relaunch_active.php?active=servicedomain&domain=".$service_domain_name[0]."'>relaunch domain</a></li>";
                        }
                        echo "</ul>";
                	echo "</div><br/>";
                	}
			}else{
			$service_serverip_res = $dbconnect->query("select DISTINCT serverip from services where userid=".$_SESSION['user_id']);
                        is_error($service_serverip_res);
                        if($service_serverip_res->numRows() == 0){
                        die("not service in web-nginx !!");
                        }
                        while($service_serverip = $service_serverip_res->fetchRow()){
                        echo '<a href="#" onclick="showElement(\''.$service_serverip[0].'\')">show: '.$service_serverip[0].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="relaunch_active.php?active=serviceip&ip='.$service_serverip[0].'">relaunch host</a>'.
                        '<div id="'.$service_serverip[0].'" style="display:none">';
                        $service_domain_name_res = $dbconnect->query("select id,domain_name from services where serverip='".$service_serverip[0]."'");
                        is_error($service_domain_name_res);
                        echo "<ul>";
                        while($service_domain_name = $service_domain_name_res->fetchRow()){
                        echo "<li><a href='addconfigs.php?serviceid=".$service_domain_name[0]."'>$service_domain_name[1]</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='relaunch_active.php?active=servicedomain&domain=".$service_domain_name[0]."'>relaunch domain</a></li>";
                        }
                        echo "</ul>";
                        echo "</div><br/>";
			}

			}
			?>

        </div>
<?php
include "tools_coltwo.php";
include "footer.php";
?>


