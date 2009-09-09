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
                        <h3>delete page</h3>
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
                        echo "<td><a href='dellocations.php?serviceid=".$services_info['id']."'>".$services_info['domain_name']."</a></td>";
                        echo "<td><a href='delservice.php'>".$services_info['serverip']."</a></td>";
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
			echo "</tr>";
			}
                        ?>
                        </table>
                </div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

