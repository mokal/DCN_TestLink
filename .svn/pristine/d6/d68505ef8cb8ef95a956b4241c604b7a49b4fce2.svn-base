 <?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();

$tplan_id = $_GET['tplanid'];
$device_id = $_GET['deviceid'];
$suite = $_GET['suite'];
$tplanname = $_GET['tplanname'];
$divindex = $_GET['divindex'];

$rs = $platform_mgr->pullCasesFromVar($tplan_id,$device_id,$suite,$args->login_username);
if($rs != 'OK'){
	echo "<script>alert('{$rs}');</script>"; 
};
echo "<script>self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplanname}&divindex={$divindex}';</script>";
exit();

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
