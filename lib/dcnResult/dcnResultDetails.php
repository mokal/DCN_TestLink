<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$gui = new stdClass();
$tplan_mgr = new testplan($db);
$build_mgr = new build_mgr($db);

$needsave = isset($_GET['save']) ? $_GET['save'] : 0 ;
$tplanid = isset($_GET['tplanid']) ? $_GET['tplanid'] : 1 ;
$buildid = isset($_GET['buildid']) ? $_GET['buildid'] : 1 ;
$deviceid = isset($_GET['deviceid']) ? $_GET['deviceid'] : 1 ;
$topotype = isset($_GET['topotype']) ? $_GET['topotype'] : 999 ;
$suite = isset($_GET['suite']) ? $_GET['suite'] : 1 ;

$gui->saveresult = 2;
if($needsave == 1){
	$result = isset($_POST['result']) ? $_POST['result'] : 'none' ;
	$result_summary = isset($_POST['result_summary']) ? $_POST['result_summary'] : '' ;
	$reviewer = isset($_POST['reviewer']) ? $_POST['reviewer'] : '' ;
	$review_summary = isset($_POST['review_summary']) ? $_POST['review_summary'] : '' ;
	$result_report = isset($_POST['result_report']) ? $_POST['result_report'] : '' ;
	$gui->saveresult = $tplan_mgr->setTestResult($tplanid,$deviceid,$buildid,$topotype,$suite,$result,$result_summary,$reviewer,$review_summary,$result_report);
}

$gui->reviewers = $tplan_mgr->get_review_users();
$dcnresult = $tplan_mgr->getTestResult($tplanid,$deviceid,$buildid,$topotype,$suite);

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->assign('tplanid',$tplanid);
$smarty->assign('buildid',$buildid);
$smarty->assign('deviceid',$deviceid);
$smarty->assign('topotype',$topotype);
$smarty->assign('suite',$suite);
$smarty->assign('result',$dcnresult);

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