<?php
include "functionapi.php";
$client_upstatus_log="clientlog/client_up_status.log";
$client_error_log="clientlog/client_error.log";
$upstatus_log_hanld=fopen($client_upstatus_log,"a+");
$clientip=$_SERVER['REMOTE_ADDR'];
$res = $dbconnect->query("select * from services where serverip='".$clientip."'");
if (PEAR::isError($res)){
$db_error=$resource->getMessage() . "\n" . $resource->getDebugInfo() . "\n";
fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." ".$db_error);
fclose($upstatus_log_hanld);
exit;
} 
if($res->numRows() == 0){
fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." "."no find your ip ".$clientip."\n");
fclose($upstatus_log_hanld);
exit;
}
if($_REQUEST['status'] == 1){
	$res=$dbconnect->query("update services set status=3 where serverip='".$clientip."'");
	if (PEAR::isError($res)){
	$db_error=$resource->getMessage() . "\n" . $resource->getDebugInfo() . "\n";
	fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." ".$db_error);
	fclose($upstatus_log_hanld);
	exit;
	}
	fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." update ".$clientip." status online \n" ); 
}
if($_REQUEST['status'] == 0){
	$res=$dbconnect->query("update services set status=4 where serverip='".$clientip."'");
        if (PEAR::isError($res)){
        $db_error=$resource->getMessage() . "\n" . $resource->getDebugInfo() . "\n";
        fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." ".$db_error);
        fclose($upstatus_log_hanld);
        exit;
        }
	if(isset($_REQUEST['error'])){
	$error_log_hanld=fopen($client_error_log,"a+");
	fwrite($error_log_hanld,"==error begin:".date("Y-m-d H:i:s")." ".$clientip."== \n".$_REQUEST['error']."\n ==error end== \n");
	fclose($error_log_hanld);	
	}
        fwrite($upstatus_log_hanld,date("Y-m-d H:i:s")." update ".$clientip." status reloaderror \n" );
}
fclose($upstatus_log_hanld);
?>
