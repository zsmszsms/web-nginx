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
                        <table name="listnginxserver">
                        <tr>
                        <th>id</th>
                        <th>Domain</th>
                        <th>server</th>
                        <th>status</th>
			<th>deletes</th>
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

			echo"<td><a href='service_active.php?active=del_service&serviceid=".$services_info['id']."&servicename=".$services_info['domain_name']."&serverip=".$services_info['serverip']."'>delete</a></td>";
                        }
			echo"</tr>";
                        ?>
                        </table>
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

