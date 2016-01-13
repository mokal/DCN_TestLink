<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();
$platform_mgr = new tlPlatform($db, $args->testproject_id);

$var_id = $_GET['varid'];
$suite_id = $_GET['suiteid'];

//var_cases
$fp = @fopen($_FILES['varfile']['tmp_name'] , "r") ;
switch($suite_id){
	case '3959'://affirm2
		if( preg_match("/^.*?\.tcl/i" , $_FILES['varfile']['name'] , $temp) ){
			if ( $fp ){
				$var_cases = array();
				while ( !feof($fp) ){
					$buffer = fgets($fp , 4096) ;
					if ( preg_match("/^set {affirm_(.*?)} 1/i" ,$buffer, $case) ) {
						$tcversion_id = $platform_mgr->getTcversionidByName($case[1],'affirm2') ;
						if( $tcversion_id != 0){
						    $var_cases[] = $tcversion_id ;
						}
					}elseif( preg_match("/^set {(bf.*?)} 1/i" ,$buffer, $case) ) {
						$tcversion_id = $platform_mgr->getTcversionidByName($case[1],'affirm2') ;
						if( $tcversion_id != 0){
						    $var_cases[] = $tcversion_id ;
						}
					}elseif( preg_match("/^set {(mt.*?)} 1/i" ,$buffer, $case) ) {
					    $tcversion_id = $platform_mgr->getTcversionidByName($case[1],'affirm2') ;
						if( $tcversion_id != 0){
						    $var_cases[] = $tcversion_id ;
						}
					}
				}
		    }
		}else{
			echo "<script>alert('文件不是affirm2.0 var.tcl文件，请确认！');self.location.href='/lib/dcnVars/viewVar.php?suite_id={$suite_id}&var_id={$var_id}' ;</script>";
			exit();
		}
		break;
	case '4944'://affirm3
		if( preg_match("/^.*?\.prj/i" , $_FILES['varfile']['name'] , $temp) ){
			if ( $fp ){
				$var_cases = array();
				while ( !feof($fp) ){
					$buffer = fgets($fp , 4096) ;
					if ( preg_match_all('/affirm_[\d\.]*\.py/' ,$buffer, $case,1) ) {
						foreach( $case[0] as $testcase){
							$testcase = str_replace('.py', '' ,$testcase) ;
							$testcase = str_replace('affirm_', '' ,$testcase) ;
							
						    $tcversion_id = $platform_mgr->getTcversionidByName($testcase,'affirm3') ;
						    if( $tcversion_id != 0){
						        $var_cases[] = $tcversion_id ;
						    }
						}
					}
				}
		    }
		}else{
			echo "<script>alert('文件不是affirm3.0 prj文件，请确认！');self.location.href='/lib/dcnVars/viewVar.php?suite_id={$suite_id}&var_id={$var_id}' ;</script>";
			exit();
		}
		break;
	case '67'://function
		if( preg_match("/^.*?\.cfg/i" , $_FILES['varfile']['name'] , $temp) ){
			if ( $fp ){
				$var_cases = array();
				while ( !feof($fp) ){
					$buffer = fgets($fp , 4096) ;
					if ( preg_match("/^(.*?)_(\d)(.*?) [A-D]1/i" ,$buffer, $case) ) {
						# $case[1] is module name $case[2]+[3] is case name
						$tcversion_id = $platform_mgr->getTcversionidByName($case[2] . $case[3],$case[1]) ;
						if( $tcversion_id != 0){
						    $var_cases[] = $tcversion_id ;
						}
					}
		    	}
			}
		}else{
			echo "<script>alert('文件不是build出来的cfg文件，请确认！');self.location.href='/lib/dcnVars/viewVar.php?suite_id={$suite_id}&var_id={$var_id}' ;</script>";
			exit();
		}
		break;
	default:
		break;
}

//testlink_cases
$testlink_varcases = $platform_mgr->getVarCases($var_id);

$gui = new stdClass();
$gui->var_id = $var_id;
$gui->suite_id = $suite_id;

$needadd = array_diff($var_cases,$testlink_varcases);
$needdelete = array_diff($testlink_varcases,$var_cases);
$gui->needadd = array();
$gui->needdelete = array();

if( !is_null($needadd) ){
    foreach($needadd as $case_tcv_id){
        $platform_mgr->modifyVarCases($var_id, $case_tcv_id, $args->login_username,'add');
        $gui->needadd[] = $platform_mgr->getTcversionName($case_tcv_id);
    }
}

if( !is_null($needdelete) ){
	foreach($needdelete as $case_tcv_id){
		$platform_mgr->modifyVarCases($var_id, $case_tcv_id, $args->login_username,'delete');
		$gui->needdelete[] = $platform_mgr->getTcversionName($case_tcv_id);
	}
}

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