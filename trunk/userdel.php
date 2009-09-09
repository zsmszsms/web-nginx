<?php
$actionid="tools";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
if($_SESSION['user_class'] != "admin"){
echo' <div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>user delete</h3>';
echo"your not admin!!";
echo"</div>";
include "tools_coltwo.php";
include "footer.php";
exit;
}

?>
 <div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>user delete</h3>
	<?
        if($_GET['deluser_error'] == "true"){
        echo "<p>del user error!!</p>";
        }
        ?>
	<hr/>
	<table name="deluser">
	<tr>
        <td>username</td>
        <td>admin</td>
	<td>delete</td>
        </tr>
        <?php
        $res = $dbconnect->query("select * from users");
        is_error($res);
        while($user_info = $res->fetchRow(DB_FETCHMODE_ASSOC)){
        echo "<tr>".
        "<td>".$user_info['username']."</td>".
        "<td>".$user_info['admin']."</td>".
	"<td><a href='tools_active.php?active=deluser&id=".$user_info['id']."'>delete</a></td>".
        "</tr>";
        }
        ?>
	</table>
	</div>


<?php
include "tools_coltwo.php";
include "footer.php";
?>

