<?php
Session_start();
include("config.php");
set_include_path(get_include_path() . ":" . $_CONF['peardb_path']);
include("DB.php");
$dsn = $_CONF['db_type'] . "://" . $_CONF['db_user'] . ":" . $_CONF['db_pass'] .
        "@" . $_CONF['db_host'] . "/" . $_CONF['db_db'];
$dbconnect = DB::connect($dsn);
if(PEAR::isError($dbconnect)) {
        die("Database error: " . $dbconnect->getMessage());
}
function isuser($username,$password){
global $dbconnect;
if($username != null && $password != null){
$res = $dbconnect->query("select * from users where username='".$username."' and password=md5('".$password."')");
	$resnum = $res->numRows();
	if($resnum == 0){
	die("username no find or password error!!place relogin<a href ='login.php'>login page</a>");
	}
}else{
die("plase,input username and password!!place relogin<a href ='login.php'>login page</a>");
}
$user_class=array();
$user_info=$res->fetchRow(DB_FETCHMODE_ASSOC);
if($user_info['admin'] == "yes"){
array_push($user_class,"admin",$user_info['id']);
return $user_class;
}else{
array_push($user_class,"user",$user_info['id']);
return $user_class;
}
}
function is_error($resource) {
        if(PEAR::isError($resource)) {
                die($resource->getMessage() . "<br><br>" . $resource->getDebugInfo());
        }
}
function addservice($domain_name,$server_ip,$user_id,$conf_name){
global $dbconnect;
$res = $dbconnect->query("insert into services (domain_name, serverip, status, conf_name, userid) values('".$domain_name."','".$server_ip."',0,'".$conf_name."',".$user_id.")");
if(PEAR::isError($res)){
return false;
}
return true;
}
function upserivce_status($status,$serviceid){
global $dbconnect;
$res = $dbconnect->query("update services set status=".$status." where id=".$serviceid);
if(PEAR::isError($res)){
return false;
}
return true;
}
function template_read($template_path_file){
$template_handle = @fopen($template_path_file, "r");
if ($template_handle) {
    while (!feof($template_handle)) {
        $buffer = fgets($template_handle);
    	$template_buffer .= $buffer."\n";
	}
    fclose($handle);
    return $template_buffer;
}
}
function commit_config_write($commit_config_name,$commit_config_content){
if(is_file($commit_config_name)){
exec("mv -f ".$commit_config_name." ".$commit_config_name.".bak");
}
$config_write_handle = fopen($commit_config_name,"w+");
	if(fwrite($config_write_handle,$commit_config_content) === FALSE){
	fclose($config_write_handle);
	return false;
	}else{
	fclose($config_write_handle);
	return true;
	}
}
function commit_log($commit_time,$service_name,$config_patch,$commit_log){;
if(!is_file($commit_log)){
touch($commit_log);
}
$commit_log_handle = fopen($commit_log,"a");
if(fwrite($commit_log_handle,$commit_time.",".$service_name.",".$config_patch."\n") == FALSE){
fclose($commit_log_handle);
return false;
}else{
fclose($commit_log_handle);
return true;
}
}
function md5file_write($md5_code,$file_path){
$md5_code_file_handle=fopen($file_path,"w+");
if(fwrite($md5_code_file_handle,$md5_code) == FALSE){
fclose($md5_code_file_handle);
return false;
}else{
fclose($md5_code_file_handle);
return true;
}
}
function authpasswd($passwdlong){
$listword='abcdefghijkmnpqrstxyABCDEFGHIJKMNPQRSTXY123456789';
$authpass=substr(str_shuffle($listword),0, $passwdlong);
return $authpass;
}
//commit to command
$upstream_commit_command=array("/:upstream_name:/","/:upstream_server_list:/");
$location_commit_command=array("/:location_path:/","/:alias:/","/:root_path:/","/:proxy_pass:/","/:proxy_next_upstream:/","/:access_log:/","/:rewrite_policy:/","/:valid_referers:/");
$server_commit_comand=array("/:server_name:/");
$version="v1.1.1";
?>
