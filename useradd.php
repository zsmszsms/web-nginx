<?php
$actionid="tools";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
if($_SESSION['user_class'] != "admin"){
echo'<div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>user add</h3>';
echo"your not admin!!";
echo '</div>';
include "tools_coltwo.php";
include "footer.php";
exit;
}
?>
 <div id="content">
        <div id="colOne">
	<h2>Nginx Services manager</h2>
	<h3>user add</h3>
	<?
	if($_GET['adduser_error'] == "true"){
	echo "<p>add user error!!</p>";
	}	
	?>
	<hr/>
	<form name="useradd" action="tools_active.php" method="post">
	<table name="useradd">
	<tr>
	<td>username</td>
	<td>restpassword</td>
	<td>admin</td>
	</tr>
	<?php
        $res = $dbconnect->query("select * from users");
        is_error($res);
        while($user_info = $res->fetchRow(DB_FETCHMODE_ASSOC)){
        echo "<tr>".
	"<td>".$user_info['username']."</td>".
	"<td><a href='tools_active.php?active=restpw&id=".$user_info['id']."'>restpassword</a></td>".
	"<td>".$user_info['admin']."</td>".
	"</tr>";
	}
        ?>
	<tr>
        <td>username</td>
        <td>password</td>
        <td>admin</td>
        </tr>
	<tr>
	<td><input name="username"></td>
	<td><input type="password" name="password"></td>
	<td><input type="checkbox" name="admin" value="yes"></td>
	</tr>
	</table>
	<input name="active" style="visibility:hidden" value="adduser">
	<center><input type="submit" value="add user"></center>
	</form>
	</div>
<?php
include "tools_coltwo.php";
include "footer.php";
?>

