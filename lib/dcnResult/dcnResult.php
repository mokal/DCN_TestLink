<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$gui = new stdClass();

$fromlink = isset($_GET['fromlink']) ? $_GET['fromlink'] : 0 ;
$tplanid = isset($_GET['tplanid']) ? $_GET['tplanid'] : 1 ;
$buildid = isset($_GET['buildid']) ? $_GET['buildid'] : 1 ;
$deviceid = isset($_GET['deviceid']) ? $_GET['deviceid'] : 1 ;
$topotype = isset($_GET['topotype']) ? $_GET['topotype'] : 999 ;
$suite = isset($_GET['suite']) ? $_GET['suite'] : 1 ;

$buildname = isset($_GET['buildname']) ? $_GET['buildname'] : '不区分版本' ;
$devicename = isset($_GET['devicename']) ? $_GET['devicename'] : '不区分设备型号' ;
$topotypename = isset($_GET['topotypename']) ? $_GET['topotypename'] : '不区分拓扑类型' ;
$suitename = isset($_GET['suitename']) ? $_GET['suitename'] : '不区分模块(测试计划结论)' ;

$tplan_mgr = new testplan($db);

$plans = $tplan_mgr->report_get_plans($args->testproject_id);
$builds = $tplan_mgr->report_get_builds();
$build_total = count($builds);
//$suites = $tplan_mgr->dcnResult_get_suites();
//$suite_total = count($suites);
$devices = $tplan_mgr->report_get_devices($args->testproject_id);
$device_total = count($devices);
$project = $args->testproject_id;

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);

$smarty->assign('fromlink',$fromlink );
$smarty->assign('tplanid',$tplanid );
$smarty->assign('buildid',$buildid );
$smarty->assign('deviceid',$deviceid );
$smarty->assign('topotype',$topotype );
$smarty->assign('suite',$suite );
$smarty->assign('buildname',$buildname );
$smarty->assign('devicename',$devicename );
$smarty->assign('topotypename',$topotypename );
$smarty->assign('suitename',$suitename );

$smarty->assign('plans',$plans );
$smarty->assign('project',$project );
$smarty->assign('builds', json_encode($builds) );
$smarty->assign('build_total', $build_total );
//$smarty->assign('suites', json_encode($suites) );
//$smarty->assign('suite_total', $suite_total );
$smarty->assign('devices', json_encode($devices) );
$smarty->assign('device_total', $device_total );

$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser'];
    $args->username = $_SESSION['currentUser']->getDisplayName();
	return $args;
}

function checkRights(&$db,&$user)
{
	return True;
}
?>