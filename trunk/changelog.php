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
        <h3>changelog</h3>
	<p>09-21-2009 add valid_referers in locations setup;</p>
        <hr/>
</div>
<?php
include "abort_coltwo.php";
include "footer.php";
?>

