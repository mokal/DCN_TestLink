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

if( !(isset($_POST['tplan_id']) && isset($_POST['device_id'])) ){
    $mysqli->close() ;
}else{
	$all_where = " WHERE testplan_id=". $_POST['tplan_id'] . " and platform_id=" . $_POST['device_id'] ;
	$part_where =" WHERE id=1 " ;
	foreach($_POST as $key=>$value){
		if($value==1){
     		$part_where .=  " or id=" . $key ;
	    }
	}
	
    $query = " UPDATE testplan_tcversions SET skip=0 " . $all_where ;
    $mysqli->query($query);
    
    $query = " UPDATE testplan_tcversions SET skip=1 " . $part_where ;
    $mysqli->query($query);
    $mysqli->close() ;
    
	echo "<script type='text/javascript'>alert('保存成功，仅针对下一次执行有效!');</script>";
}
?>