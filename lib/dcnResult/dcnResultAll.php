<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$gui = new stdClass();
$tplan_mgr = new testplan($db);

$tplanid = isset($_GET['tplanid']) ? $_GET['tplanid'] : 1 ;

$dcnresult = $tplan_mgr->getTestPlanAllResult($tplanid);

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->assign('tplanid',$tplanid);
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