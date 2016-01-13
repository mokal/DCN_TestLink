<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$gui->runningjobs = $platform_mgr->getAllRunningjobs();
$gui->user = $args->user;
$gui->device_name  = $platform_mgr->getDeviceName($args->productline_id, $args->device_id);
$gui->productline_id = $args->productline_id;
$gui->device_not_box = preg_match("/6800|6804|6808|7600|7604|7608|9800|9808|16809/",$gui->device_name);

$allaffirm3env = json_encode($platform_mgr->getAllAffirm3Env());
$allwaffirmenv = json_encode($platform_mgr->getAllWirelessAffirmEnv());

setcookie(job_productline_id, $args->productline_id);
setcookie(job_tplan_id,$args->tplan_id);
setcookie(job_build_id,$args->build_id);
setcookie(job_device_id,$args->device_id);
setcookie(job_user_name,$args->user);

$jobhistory = json_encode($platform_mgr->getJobHistory($args->tplan_id, $args->user));
$par_detail = json_encode($platform_mgr->getParDetail($args->device_id));
$is_poncat_function_var = $platform_mgr->isPoncatFunctionVar($args->device_id);
$function_env_detail = json_encode($platform_mgr->getAllFunctionEnv());
$poncat_function_env_detail = json_encode($platform_mgr->getPoncatAllFunctionEnv());

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->assign('allaffirm3env',$allaffirm3env);
$smarty->assign('allwaffirmenv',$allwaffirmenv);
$smarty->assign('jobhistory',$jobhistory);
$smarty->assign('par_detail',$par_detail);
$smarty->assign('poncat_var',$is_poncat_function_var);
$smarty->assign('function_env_detail',$function_env_detail);
$smarty->assign('poncat_function_env_detail',$poncat_function_env_detail);

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