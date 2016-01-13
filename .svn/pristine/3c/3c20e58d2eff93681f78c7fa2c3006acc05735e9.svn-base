<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();

$gui->nowdate = isset($_POST['mydate']) ? $_POST['mydate'] : strftime("%Y-%m",time());
$gui->postdate = isset($_POST['mydate']) ? $_POST['mydate'] : 0;
$gui->tpreport = isset($_POST['testplan_monthreport']) ? $_POST['testplan_monthreport'] : 0;

if ( isset($_POST['mydate']) ){
    $gui->monthJobs = $platform_mgr->getMonthReport($_POST['mydate'],$gui->tpreport);
    $gui->num_monthJobs = count($gui->monthJobs);
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
