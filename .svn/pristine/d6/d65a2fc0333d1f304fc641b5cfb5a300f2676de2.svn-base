<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$args = init_args();
$platform_mgr = new tlPlatform($db, $args->testproject_id);

$var_id = $_GET['varid'];
$suite_id = $_GET['suiteid'];
$all = $_GET['all'];
$verify = isset($_GET['verify']) ? $_GET['verify'] : 0 ;


$needdelete_tplan_device = array_keys($_POST);
	
$devices = $platform_mgr->getVarDevices($var_id,$suite_id);
foreach($devices[0] as $device){
	$tplans = $platform_mgr->getDeviceTplan($device['id'],$all);
	foreach($tplans[0] as $tplan){
		if( in_array($tplan['id'].'-'.$device['id'],$needdelete_tplan_device) ){
			$platform_mgr->modifyTplanCasesFromVar($tplan['id'],$device['id'],$var_id,$suite_id,$args->login_username,'delete');
		}
	}
}
	
echo "<script> {window.alert('处理完毕！');location.href='/lib/dcnVars/viewVar.php?var_id={$var_id}&suite_id={$suite_id}'} </script>";

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 
	$args->login_username = $_SESSION['currentUser']->getDisplayName();
	return $args;
}
function checkRights(&$db,&$user)
{
	return True;
}
?>