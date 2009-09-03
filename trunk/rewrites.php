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
	<?php
	switch($_GET['rewrite_error']){
		case 1:
		echo"<p>comments not use null !</p>";
		case 2:
		echo"<p>protasis differ with a comments !!</p>";
	}
	$res = $dbconnect->query("select DISTINCT comments from rewrites");
	is_error($res);
	if($res->numRows() > 0){
	echo "<p>list nginx rewrite policy</p>";
	while($rewrite_policy_comments_info = $res->fetchRow()){
		$rewrite_policy_info_res = $dbconnect->query("select * from rewrites where comments='".$rewrite_policy_comments_info[0]."'");
		is_error($rewrite_policy_info_res);
		$rewrite_policy_id=$rewrite_policy_comments_info[0];
		echo "<a href='#' onclick='showElement(\"".$rewrite_policy_id."\")'>$rewrite_policy_id</a>&nbsp;&nbsp;<a href='rewrite_active.php?active=delrewrite&comment=".$rewrite_policy_id."'>delete</a>";
                echo "<div id='".$rewrite_policy_id."' style='display:none'>";
		 $rewrite_policy_contect="";
		while($rewrite_policy_info=$rewrite_policy_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
		$rewrite_policy_contect.=$rewrite_policy_info['method']."; <a href='rewrite_modif.php?id=".$rewrite_policy_info['id']."'>edit</a>&nbsp;<a href='rewrite_active.php?active=delrewrite&id=".$rewrite_policy_info['id']."&comments=".$rewrite_policy_id."'>delete</a><br/>";
		$rewrite_policy_protasis=$rewrite_policy_info['protasis'];	
		}
		if($rewrite_policy_protasis != null){
		echo "if(".$rewrite_policy_protasis.") {<br />".
			$rewrite_policy_contect."<br/>".
			"}<br/>";
		}else{
		echo $rewrite_policy_contect;
		}
		echo"</div><br/>";
	}
	}
	?>
	<hr/>
	<p>add nginx rewrite policy</p>
	<a href="#" onclick="showElement('addrewritepolicy')">show control</a>
	<div id="addrewritepolicy">
	<form action="rewrite_active.php" method="post">
	<table name="rewrite_policy">
	<tr>
	<td>protasis:</td><td><input name="protasis" size="30"></td>
	</tr>
	<tr>
	<td>action:</td><td><select name="action">
	<option value="">custom</option>
	<option value="proxy_pass">proxy_pass</option>
	<option value="set">set</option>
	<option value="return">return</option>
	<option value="break">break</option>
	</select></td>
	</tr>
	<tr>
	<td>method:</td><td><input name="method" size="30"></td>
	</tr>
	<tr>
	<td>flags:</td><td><select name="flags">
	<option value="">custom</option>
	<option value="last">last</option>
	<option value="break">break</option>
	<option value="redirect">redirect</option>
	<option value="permanent">permanent</option>
	</select></td>
	</tr>
	<tr>
	<td>comments:</td><td><input name="comments" size ="30"></td>
	</tr>
	</table>
	<input style="visibility:hidden" name="active" value="addpolicy">
	<center><input type="submit" value="add policy"></center>
	</div>
	</div>
<?php
include "config_coltwo.php";
include "footer.php";
?>
