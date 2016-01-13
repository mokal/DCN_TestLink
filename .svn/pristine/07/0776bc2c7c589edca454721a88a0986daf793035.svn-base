<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);
$now_date = strftime("%Y-%m",time());
$three_month_ago = strftime("%Y-%m",strtotime("-3 months",time())); 

$gui = new stdClass();
$gui->div = "now" ;
if ( isset($_GET['div'] ) ){
	$gui->div = $_GET['div'];
}elseif( isset($_GET['div']) ){
	$gui->div = $_POST['div'];
}

if( isset($_POST['fromdate']) && isset($_POST['todate']) ){
	$gui->div = 'history';
}

$gui->fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : $three_month_ago;
$gui->todate = isset($_POST['todate']) ? $_POST['todate'] : $now_date;

$gui->runningjobs = $platform_mgr->getAllRunningjobs();

$gui->runendjobs = $platform_mgr->getAllRunendjobs($gui->fromdate,$gui->todate);
$gui->cloudjobs = $platform_mgr->getAllCloudjobs();

$gui->userCanDeleteJob = $platform_mgr->userCanDeleteJob($args->username);

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
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