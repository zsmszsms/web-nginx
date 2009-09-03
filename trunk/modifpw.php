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
        <h2>Nginx Services manager</h2>
	<h3>modif password</h3>
	<?php
	if($_GET['modifpw_error'] == 1){
	echo"<p>modif password error!!</p>";
	}
	?>
	<hr/>
	<form name="modifpass" action="tools_active.php" method="post">        
	<table name="modifpass">
	<tr>
	<td>your name:</td><td><input name="username" value="<?=$_SESSION['username']?>" readonly></td>
	</tr>
	<tr>
	<td>your old password:</td><td><input name="oldpassword" type="password"></td>
	</tr>
	<tr>
	<td>your new password:</td><td><input name="newpassword" type="password"></td>
	</tr>
	<tr>
	<td>replay new password:</td><td><input name="replaypassword" type="password"></td>
	</tr>
	</table>
	<input name="active" style="visibility:hidden" value="modifpw">
	<input type="submit" value="changed password">	
	</div>
<?php
include "tools_coltwo.php";
include "footer.php";
?>

