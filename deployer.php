<?php
$actionid="abort";
include "head.php";
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
?>
<div id="content">
        <div id="colOne">
        <h2>Nginx Services manager</h2>
        <h3>developer list:</h3>
        <hr/>
        <p><a href="#">yangduqing</a></p>
	<p>email:<a href="mailto:yangduqing@staff.hexun.com">yangduqing@staff.hexun.com</a></p>
        <p>homepage:<a href="www.ideation-cn.cn">dodo blog</a></p>
</div>
<?php
include "abort_coltwo.php";
include "footer.php";
?>

