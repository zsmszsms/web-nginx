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
	<h3>Maps</h3>
	<hr/>
	<?php
	if($_SESSION['user_class'] == "admin"){ 
	switch($_REQUEST['maps_active']){
		case "ip":
		$service_serverip_res = $dbconnect->query("select DISTINCT serverip from services");
		is_error($service_serverip_res);
		if($service_serverip_res->numRows() == 0){
		die("not service in web-nginx !!");
		}
		while($service_serverip = $service_serverip_res->fetchRow()){
		$service_domain_name_res = $dbconnect->query("select id,domain_name from services where serverip='".$service_serverip[0]."'");
		is_error($service_domain_name_res);
		$count_domains=$service_domain_name_res->numRows();
		echo '<a href="#" onclick="showElement(\''.$service_serverip[0].'\')">show: '.$service_serverip[0].'|count domains:'.$count_domains.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="modif_service_host.php?serverip='.$service_serverip[0].'">edit</a>'.
		'<div id="'.$service_serverip[0].'" style="display:none">';
		//$service_domain_name_res = $dbconnect->query("select id,domain_name from services where serverip='".$service_serverip[0]."'");
		//is_error($service_domain_name_res);
			echo "<ul>";
			while($service_domain_name = $service_domain_name_res->fetchRow()){
			echo "<li><a href='addconfigs.php?serviceid=".$service_domain_name[0]."'>$service_domain_name[1]</a></li>";
			}
			echo "</ul>";
		echo "</div><br/>";
		}
		break;
		case "domain":
		$service_domain_name_res = $dbconnect->query("select DISTINCT domain_name from services");
		 is_error($service_domain_name_res);
                if($service_domain_name_res->numRows() == 0){
                die("not service in web-nginx !!");
                }
		while ($service_domain_name = $service_domain_name_res->fetchRow()){
		$service_serverip_res = $dbconnect->query("select id,serverip from services where domain_name='".$service_domain_name[0]."'");
		is_error($service_serverip_res);
		$count_ips=$service_serverip_res->numRows();
		echo '<a href="#" onclick="showElement(\''.$service_domain_name[0].'\')">show: '.$service_domain_name[0].'|count ips:'.$count_ips.'</a>'.
		'<div id="'.$service_domain_name[0].'" style="display:none">';
			 echo "<ul>";
			while($service_serverip = $service_serverip_res->fetchRow()){
			echo "<li><a href='addconfigs.php?serviceid=".$service_serverip[0]."'>$service_serverip[1]</a></li>";
			}
			echo "</ul>";
                	echo "</div><br/>";
                
		}
		break;
	
	}
	}else{
	echo "<p>your not admin!!</p>";
	}	
	?>
</div>
<?php
include "maps_coltwo.php";
include "footer.php";
?>


