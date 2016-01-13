 <?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$gui->tplan_id = $_GET['id'];

$_SESSION["testplanID"] = $gui->tplan_id ;

$gui->tplanDevices = $platform_mgr->getTplanDevices($gui->tplan_id);

$gui->totalDevices = count($gui->tplanDevices) - 1 ;
$gui->tplanCases = $platform_mgr->getTplanTestCases($gui->tplan_id);
$gui->tplanName = $_GET['name'];
$gui->username = $args->login_username ;
$gui->divindex = 0;
if( isset($_GET['divindex']) ){
	$gui->divindex = $_GET['divindex'] ;
}

$tplan_mgr = new testplan($db);
$gui->suites = $tplan_mgr->get_all_suites();

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);


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
