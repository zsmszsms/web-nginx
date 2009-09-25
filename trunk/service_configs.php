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
                        echo"</tr>";
			}
                        ?>
                        </table>
                </div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

