<?php
$mysqli = new mysqli("192.168.50.192","testlink","Eqp9qH9Pya9FMVyV","testlink");
$mysqli->set_charset("utf8");

if( !isset($_GET['tplan_id']) || !isset($_GET['device_id']) ){
    echo "<script>alert('Error access!!!');</script>" ;
    $mysqli->close() ;
    exit();
}else{
   $tplan_id = $_GET['tplan_id'];
   $device_id = $_GET['device_id'];

//var_cases
    $fp = @fopen($_FILES['varfile']['tmp_name'] , "r") ;
    if ( $fp ){
       $var_cases = array();
       while ( !feof($fp) ){
          $buffer = fgets($fp , 4096) ;
          if ( preg_match("/^set {affirm_(.*?)} 1/i" ,$buffer, $case) ) { 
                  $var_cases[] = $case[1] ;

          }elseif( preg_match("/^set {(bf.*?)} 1/i" ,$buffer, $case) ) { 
                $var_cases[] = $case[1] ;
          }
        }
     }

//testlink_cases
     $query = " UPDATE executions SET fail_type = '{$failtype}' WHERE id = {$id} " ;
     $mysqli->query($query);





  $mysqli->close() ;
}

?>



<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$gui->tplan_id = $_GET['id'];

$gui->tplanDevices = $platform_mgr->getTplanDevices($gui->tplan_id);

$gui->totalDevices = count($gui->tplanDevices) - 1 ;

$gui->tplanCases = $platform_mgr->getTplanTestCases($gui->tplan_id);
$gui->tplanName = $_GET['name'];


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

