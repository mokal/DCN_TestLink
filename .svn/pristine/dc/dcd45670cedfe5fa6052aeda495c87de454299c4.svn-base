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
    echo "<script>alert('Error access!!!');</script>";
    $mysqli->close();
    exit();
}else{
    $id = $_GET['id'];
    if( isset($_GET['note']) ){
         $note = $_GET['note'];
         $endtime = $_GET['time'];
         $query = " UPDATE run_end_jobs SET endwhy = '{$note}',job_endTime='{$endtime}' WHERE job_id = '{$id}' ";
         $mysqli->query($query);
     }
    $mysqli->close();
}

?>