<?php
function clientIP(){
	$cIP = getenv('REMOTE_ADDR');
	$cIP1 = getenv('HTTP_X_FORWARDED_FOR');
	$cIP2 = getenv('HTTP_CLIENT_IP');
	$cIP1 ? $cIP = $cIP1 : null;
	$cIP2 ? $cIP = $cIP2 : null;
	return $cIP;
}
$sql_server = "192.168.50.192";

if (preg_match('/^192\.168\.60\..*/i', clientIP())){
	$sql_server = "192.168.60.47";
}

$mysqli = new mysqli($sql_server,"testlink","Eqp9qH9Pya9FMVyV","testlink");
$mysqli->set_charset("utf8");

if( !isset($_GET['id']) ){
    echo "<script>alert('Error access!!!');</script>" ;
    $mysqli->close() ;
    exit();
}else{
    $id = $_GET['id'];
    if( isset($_GET['fail']) ){
         $failtype = $_GET['fail'];
         $query = " UPDATE executions SET fail_type = '{$failtype}' WHERE id = {$id} " ;
         $mysqli->query($query);

         $query = " UPDATE job_testcase SET fail_type = '{$failtype}' WHERE exe_id={$id} " ;
         $mysqli->query($query);
     }

    if( isset($_GET['note']) ){
         $note = $_GET['note'];
         $query = " UPDATE executions SET notes = '{$note}' WHERE id = {$id} " ;
         $mysqli->query($query);
     }
    $mysqli->close() ;
}
?>