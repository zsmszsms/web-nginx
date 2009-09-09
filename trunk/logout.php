<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
session_start();
session_destroy();
$headerinfo="location: login.php";
header($headerinfo);
?>

