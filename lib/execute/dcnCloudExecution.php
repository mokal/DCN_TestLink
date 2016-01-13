<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$gui->user = $args->user;
$gui->device_name  = $platform_mgr->getDeviceName($args->productline_id, $args->device_id);
$gui->productline_id = $args->productline_id;

setcookie(job_productline_id, $args->productline_id);
setcookie(job_tplan_id,$args->tplan_id);
setcookie(job_build_id,$args->build_id);
setcookie(job_device_id,$args->device_id);
setcookie(job_user_name,$args->user);

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);

$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->user = $_SESSION['currentUser']->getDisplayName();
    $args->productline_id = $args->testproject_id;

    $args->tplan_id = $_GET['tplan'];
    $args->build_id = $_GET['build'];
    $args->device_id = $_GET['device'];
	return $args;
}

function checkRights(&$db,&$user)
{
	return True;
}
?>