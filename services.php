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
			<?
			$res = $dbconnect->query("select * from services");
			is_error($res);
			$servicesum=$res->numRows();
			$res = $dbconnect->query("select DISTINCT serverip from services");
			is_error($res);
			$serveripsum=$res->numRows();
			$res = $dbconnect->query("select * from services where status<>3");
			is_error($res);
			$errorsum=$res->numRows();
			echo "<p>service sum :".$servicesum." server sum:".$serveripsum." error sum: ".$errorsum."</p>";
                        echo "<hr/>";
			if($res->numRows() >0){
			echo "<a href='#' onclick='showElement(\"error_service\" )' style='display:none'>error service</a>";
			echo "<div id='error_service'>";
			echo ' <table name="error_service">
                        <tr>
                        <th>id</th>
                        <th>Domain</th>
                        <th>server</th>
                        <th>status</th>
                        <th>viwes</th>
                        </tr>';
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
                                echo "<td><img src='img/computernew.gif' title='service status new'></td>";
                                break;
                                case 1:
                                echo "<td><img src='img/computeredit.gif' title='service status changed'></td>";
                                break;
                                case 2:
                                echo "<td><img src='img/commentadd.gif' title='service status comment'></td>";
                                break;
                                case 3:
                                echo "<td><img src='img/computerstart.gif' title='service status online'></td>";
                                break;
                                case 4:
                                echo "<td><img src='img/computerstop.gif' title='service status config error'></td>";
                                break;
                        }
                        if ($services_info['status'] > 1){
                        echo "<td><a href='config_dir/".$services_info['serverip']."/".$services_info['conf_name'].".vservice' target='_blank'>view</a></td>";
                        }
                        echo"</tr>";
			}
			echo "</table>".
			"</div>";
			}
			?>
                        <h3>Nginx Services list</h3>
			<table name="listnginxserver">
                        <tr>
                        <th>id</th>
                        <th>Domain</th>
                        <th>server</th>
                        <th>status</th>
			<th>viwes</th>
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
				echo "<td><img src='img/computernew.gif' title='service status new'></td>";
				break;
				case 1:
				echo "<td><img src='img/computeredit.gif' title='service status changed'></td>";
				break;
				case 2:
				echo "<td><img src='img/commentadd.gif' title='service status comment'></td>";
				break;
				case 3:
				echo "<td><img src='img/computerstart.gif' title='service status online'></td>";
				break;
				case 4:
				echo "<td><img src='img/computerstop.gif' title='service status config error'></td>";
				break;
			}
			if ($services_info['status'] > 1){
			echo "<td><a href='config_dir/".$services_info['serverip']."/".$services_info['conf_name'].".vservice' target='_blank'>view</a></td>";
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
