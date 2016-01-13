<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>DCN测试中心|测试管理系统---job删除后台</title>
</head>
<body>
<div id="main">

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

if( isset($_GET['jobid']) ){
	$jobid = $_GET['jobid'] ;
	if( !isset($_GET['confirm']) ){
    	echo "<script>if(window.confirm('确认要删除{$jobid}的一切记录吗?')) location.href='deletejob.php?jobid={$jobid}&confirm=yes';else self.close();;</script>";  
	}elseif( isset($_GET['jobid']) && $_GET['confirm']=='yes' ){
    	$mysqli = new mysqli($sql_server,"testlink","Eqp9qH9Pya9FMVyV","testlink");
    	$mysqli->set_charset("utf8");
    
  	  	$jobid = $_GET['jobid'] ;
      	$sql = " DELETE  FROM run_end_jobs WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	$sql = " DELETE FROM running_jobs WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	$sql = " DELETE FROM run_cloud_jobs WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	$sql = " DELETE FROM job_testcase WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
	
    	$sql = " DELETE FROM executions WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM affirm2_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM affirm3_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM affirmwireless_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM a_college_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM a_oversea_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE FROM a_financial_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);

    	$sql = " DELETE  FROM v_performance_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	
    	$sql = " DELETE  FROM function_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    
    	$sql = " DELETE  FROM a_cmd_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	$sql = " DELETE  FROM a_memorytest_exec_record WHERE job_id = '{$jobid}' ";
    	$mysqli->query($sql);
    	

    	echo "</br><br><br><p align='center'>数据库清理成功！！！</p>" ;

    	$mysqli->close() ;

    	$conn = ftp_connect("192.168.60.60");
    	ftp_login($conn,"testlink" , "testlink");
    	$files = ftp_nlist($conn, $jobid);
    	foreach($files as $key=>$value){
        	ftp_delete( $conn, $value );
    	}
    	$a = ftp_rmdir($conn, $jobid );
    	ftp_quit($conn);

    	$conn = ftp_connect("192.168.50.193");
    	ftp_login($conn,"testlink" , "testlink");
    	$files = ftp_nlist($conn, $jobid);
    	foreach($files as $key=>$value){
       		ftp_delete( $conn, $value );
    	}
    	$a = ftp_rmdir($conn, $jobid );  
    	ftp_quit($conn);
        
    	echo "</br><br><br><p align='center'>log文件清理成功！！！</p>" ;
         echo "<script>window.close();</script>";
	}
}
?>

</div>
</body>

</html>