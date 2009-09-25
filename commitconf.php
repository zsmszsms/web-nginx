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
		<h3>uplode nginx template</h3>
		<?php
		switch($_GET['uptemplate_error']){
			case 1:
			echo "<p>upload file error!!</p>";
			case 2:
			echo "<p>upload file is already exists.</p>";
			case 3:
			echo "<p>upload file type is error!!</p>";
			case 4:
			echo "<p>delete file error!!</p>";
		}
		switch($_GET['commit_error']){
			case 1:
			echo "<p>place check service!!</p>";
			case 2:
			echo "<p>program error!! not write file !!</p>";
		}
		$res = $dbconnect->query("select * from templates");
		$resnum = 0;
		if($res->numRows() > 0){
		echo "<form action='commitconf_active.php' method='post'>".
		"<select name='template_name'>";
		$resnum = 1;
		}
		while($templates_info=$res->fetchRow(DB_FETCHMODE_ASSOC)){
		echo "<option value='".$templates_info['template_name']."'>".$templates_info['template_name']."</option>";
		}
		if($resnum == 1){
		echo"<input type='submit' value='delete'>".
		"<input style='visibility:hidden' name='active' value='deltemplate'>".
		"</form>";
		}
		?>
		<hr/>
		<form action="template-upload.php" method="post" enctype="multipart/form-data">
		uplode nginx template:<br/>
		<select name="template_type">
		<option value="upstream">upstream</option>
		<option value="location">location</option>
		</select>
		<input name="userfile" type="file"/></br>
		<center><input type="submit" value="upload template"/></center>
		</form>
		<hr/>
		<h3>commit nginx config</h3>
		<table name="template_name">
		<tr>
		<td>service</td>
		</tr>
		<?php
		$res = $dbconnect->query("select * from services where status=1");
                is_error($res);
$res = $dbconnect->query("select * from services where status=1");
                is_error($res);
                $commit_service_sum = 0;
                if($res->numRows() > 0){
                $commit_service_sum = 1;
                echo "<form action='commitconf_active.php' method='post'>".
                "<tr>".
                "<td><select name='service_id'>";
                }
                while($commit_service_name = $res->fetchRow(DB_FETCHMODE_ASSOC)){
                echo "<option value='".$commit_service_name['id']."'>".$commit_service_name['id'].$commit_service_name['domain_name']."</option>";
                }
                if($commit_service_sum == 1){
                echo"</select></td>";
		echo"</tr>";
		?>	
		<tr>
		<td>upstream</td>
		</tr>
		<?php
		$res = $dbconnect->query("select * from templates where template_type='upstream'");
		is_error($res);
		echo"<tr>";
		echo"<td><select name='template_upstream'>";
		while($template_upstream_name = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		echo "<option value='".$template_upstream_name['template_name']."'>".$template_upstream_name['template_name']."</option>";
		}
		echo "</select></td>";
		}
		echo "</tr>";
		?>
		<tr>
		<td>location</td>
                </tr>
		<?php
		if($commit_service_sum == 1){
                $res = $dbconnect->query("select * from templates where template_type='location'");
                is_error($res);
		echo"<tr>";
                echo"<td><select name='template_location'>";
                while($template_location_name = $res->fetchRow(DB_FETCHMODE_ASSOC)){
                echo "<option value='".$template_location_name['template_name']."'>".$template_location_name['template_name']."</option>";
                }
                echo "</select></td>";
		}
		echo "</tr>";
		?>
		<tr>
		<td>commit all</td>
                </tr>
		<?php
		if($commit_service_sum == 1){
		echo "<tr>";
		echo "<td><input type='checkbox' name='commit_all' /></td>";
		echo"</tr>";
		}	
		if($commit_service_sum != 1){
		echo "<tr><td>no find commit services!</td></tr>";
		}
		?>
			
		</table>
		<?php
		if($commit_service_sum == 1){
		echo "<input style='visibility:hidden' name='active' value='commit_config'>".
		"<center><input type='submit' value='commit config'><center>".
		"</form>";	
		}
		?>				
			
	</div>
<?php
include "config_coltwo.php";
include "footer.php";
?>

