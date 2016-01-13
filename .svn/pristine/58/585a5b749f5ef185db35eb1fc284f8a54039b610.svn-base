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
$divindex = $_GET['divindex'];
$name = $_GET['tplanname'];

$cases = $platform_mgr->getTplanCasesScripts($tplan_id,$device_id);

$index = rand(1,10);
$filename = "../../upload_area/exec_logs/var_export/testlink_cases{$index}.testlink";
$file = fopen($filename,'w');
$text = "# This file file is created by TestLink!\r\n";
fwrite($file,$text);

foreach($cases as $case){
	$text = '#' . $case['script'] . '#' . "\r\n";
	fwrite($file,$text);
}
fclose($file);
echo "<script>window.open('{$filename}');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplanname}&divindex={$divindex}&name={$name}';</script>";
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
