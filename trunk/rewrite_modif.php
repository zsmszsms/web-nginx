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
        <h3>Rewrite Module</h3>
	<p>modif rewrite</p>
	<form name="modifrewrite" action="rewrite_active.php" method="post">
	<?php
	if($_GET['id'] == null){
	die("program error!!");	
	}
	$res = $dbconnect->query("select * from rewrites where id=".$_GET['id']);
	$rewrites_info_res = $res->fetchRow(DB_FETCHMODE_ASSOC);
	if($rewrites_info_res['protasis'] != null){
	echo "<table name='modifrewrite'>".
	"<tr>".
	"<td>protasis</td>".
	"<td><input name='protasis' size='30' value='".$rewrites_info_res['protasis']."'></td>".
	"</tr><tr>".
	"<td>method</td>".
	"<td><input name='method' size='30' value='".$rewrites_info_res['method']."'></td>".
	"</tr>".
	"</table>";	
	}else{
	echo "<table name='modifrewrite'>".
        "<tr>".
	"<td>method</td>".
        "<td><input name='method' size='30' value='".$rewrites_info_res['method']."'></td>".
	"</tr>".
        "</table>";		
	}
	echo "<input style='visibility:hidden' name='active' value='modifrewrite'>".
	"<input style='visibility:hidden' name='id' value='".$_GET['id']."'>".
	"<input style='visibility:hidden' name='comments' value='".$rewrites_info_res['comments']."'>".
	"<input type='submit' value='modif rewrite'>";	
	?>
	</form>
        </div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

