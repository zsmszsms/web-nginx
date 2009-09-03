<?php
$actionid="services";
include "head.php";
include "functionapi.php";
if($_POST['username'] != null && $_POST['password'] != null){
$user_class=array();
$_SESSION['username']=$_POST['username'];
$user_class = isuser($_POST['username'],$_POST['password']);
	if($user_class[0] == "admin"){
	$_SESSION['user_class']="admin";
	$_SESSION['user_id']=$user_class[1];
	}else{
	$_SESSION['user_class']="user";
	$_SESSION['user_id']=$user_class[1];
	}
}else{
	if ($_SESSION['user_class'] == null){
	die("place relogin<a href ='login.php'>login page</a>");	
	}
}
?>
 <div id="content">
                <div id="colOne">
                        <h2>Nginx Services manager</h2>
			<table name="listnginxserver">
                        <tr>
                        <th>id</th>
                        <th>Domain</th>
                        <th>server</th>
                        <th>status</th>
                        </tr>
			<?
			if($_SESSION['user_class'] == "admin"){
			$res = $dbconnect->query("select * from services");
			is_error($res);
			}else{
			$res = $dbconnect->query("select * from services where userid=".$_SESSION['user_id']);
			is_error($res);
			}
			while($services_info=$res->fetchRow(DB_FETCHMODE_ASSOC)){
			echo "<tr>";
			echo "<td>".$services_info['id']."</td>";
			  if($services_info['status'] == 0){
                        echo "<td><a href='config_active.php?active=newconfig&serviceid=".$services_info['id']."'>".$services_info['domain_name']."</a></td>";
                        }else{
                        echo "<td><a href='config_active.php?active=modifconfig&serviceid=".$services_info['id']."'>".$services_info['domain_name']."</a></td>";
                        }
                        echo "<td><a href='modifservice.php?id=".$services_info['id']."'>".$services_info['serverip']."</a></td>";
			switch($services_info['status']){
				case 0:
				echo "<td>new service</td>";
				break;
				case 1:
				echo "<td>chenged</td>";
				break;
				case 2:
				echo "<td>commited</td>";
				break;
				case 3:
				echo "<td>online</td>";
				break;
				case 4:
				echo "<td>cf error</td>";
				break;
			}
			echo"</tr>";
			}	
			?>
                        </table>
                </div>
<?php
include "service_coltwo.php";
include "footer.php";
?>
