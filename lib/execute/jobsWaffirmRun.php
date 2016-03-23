<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();

$envno = $_POST['affirmWirelessEnvSel'];
if($envno != 4 ){ $job_type = $suite = 'waffirm' ;}
if($envno == 4){ $job_type = $suite = 'waffirm_X86' ;}

$job_is_running = $platform_mgr->getJobExist($args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $job_type);
$total_case =  $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,$suite,'all');

if($job_is_running){
  echo "<script> {window.alert('该环境上已经有任务在在执行中，请检查');location.href='/lib/dcnJobs/jobsView.php'} </script>";
}
if($total_case == 0){
  echo "<script> {window.alert('该版本上没有制定覆盖策略(测试例为0)，请检查');location.href='/lib/dcnJobs/jobsView.php'} </script>";
}
else{
  //生成一个jobid：user+时间戳
    $jobid = (string)$args->user_name . (string)time();
    $client_ip = getIP();
    $s1ip = $_POST['waffirms1ip']; 
    $s2ip = $_POST['waffirms2ip']; 
    $s1p1 = $_POST['waffirms1p1']; 
    $s2p1 = $_POST['waffirms2p1']; 
    
    $s3ip = $_POST['waffirms3ip'];
    $s3p1 = $_POST['waffirms3p1']; 
    $s3p2 = $_POST['waffirms3p2']; 
    $s3p3 = $_POST['waffirms3p3']; 
    $s3p4 = $_POST['waffirms3p4']; 
    $s3p5 = $_POST['waffirms3p5']; 
    $s3p6 = $_POST['waffirms3p6']; 
    
    $pc1 = $_POST['waffirmpc1']; 
    $tester_wired = $_POST['waffirmtester']; 
    $sta1 = $_POST['waffirmsta1']; 
    $sta2 = $_POST['waffirmsta2']; 
    $ap1 = $_POST['waffirmap1'];
    $ap2 = $_POST['waffirmap2'];    
    $env_id = $_POST['affirmWirelessEnvSel'];
    
    $s1name = $_POST['waffirms1name'];
    $s2name = $_POST['waffirms2name'];
    $s3name = $_POST['waffirms3name'];
    $ap1name = $_POST['waffirmap1name'];
    $ap2name = $_POST['waffirmap2name'];
    
    $setdefault = $_POST['affirmWirelessSetDefault'];
    $upgrade = $_POST['affirmWirelessUpgrade'];
    
    $platform_mgr->addJob($jobid,'all', $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    $platform_mgr->addWirelessAffirmRun($jobid,$env_id,$s1ip,$s1name,$s1p1,$s2ip,$s2name,$s2p1,$s3ip,$s3name,$s3p1,$s3p2,$s3p3,$s3p4,$s3p5,$s3p6,$pc1,$tester_wired,$sta1,$sta2,$ap1,$ap1name,$ap2,$ap2name,$setdefault,$upgrade);
    
    echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php';} </script>";

    return 0;
}

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 
	$args->productline_id = $_COOKIE['job_productline_id'];
	$args->tplan_id = $_COOKIE['job_tplan_id'];
	$args->build_id = $_COOKIE['job_build_id'];
	$args->device_id = $_COOKIE['job_device_id'];
	$args->user_name = $_COOKIE['job_user_name'];

	return $args;
}

function getIP()
{
	global $_SERVER;
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} else if (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} else if (getenv('REMOTE_ADDR')) {
		$ip = getenv('REMOTE_ADDR');
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function checkRights(&$db,&$user)
{
	return True;
}

?>
