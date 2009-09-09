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
        <h3>Help v1.0</h3>
        <hr/>
        <p>web-nginx v1.0</p>
        <p>building.....</p>
</div>
<?php
include "abort_coltwo.php";
include "footer.php";
?>
