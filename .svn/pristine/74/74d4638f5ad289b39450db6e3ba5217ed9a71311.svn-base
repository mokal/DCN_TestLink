<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);


$gui = new stdClass();

$gui->job_id = isset($_GET['id']) ? $_GET['id'] : 0;
if ( isset($_GET['id']) ){
    $gui->jobReport = $platform_mgr->getMonthReportJob($_GET['id']);
}


$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);


function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 

	return $args;
}

function checkRights(&$db,&$user)
{
	return True;
}

?>
