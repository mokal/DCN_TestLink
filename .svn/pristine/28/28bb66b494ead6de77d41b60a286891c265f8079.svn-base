<?php
/** 
 * @author	guomf
 * Show Test Results
 */
require('../../config.inc.php');
require_once('common.php');
require_once('displayMgr.php');

$templateCfg = templateConfiguration();

$args = init_args($db);
$tplan_id = $_GET['tplan_id'];
$build_id = $_GET['build_id'];
$device_id = $_GET['device_id'];
$suite_id = $_GET['suite_id'];
$failtype = $_GET['failtype'];
$args->format = 0;
$stack = isset($_GET['stack'])? $_GET['stack'] : 0;
$mystack = isset($_GET['mystack'])? $_GET['mystack'] : 0;

$tplan_mgr = new testplan($db);

$platformSet = $tplan_mgr->getPlatforms($tplan_id,array('outputFormat' => 'map'));

if($args->device_id == '1'){
	foreach($platformSet as $this_device_id=>$device_name){
		$tplan_mgr->modify_device_build_exec_fail_type($tplan_id,$build_id,$this_device_id,$mystack,$suite_id,$failtype);
	}
}else{
	$tplan_mgr->modify_device_build_exec_fail_type($tplan_id,$build_id,$device_id,$mystack,$suite_id,$failtype);
}

echo("<script>alert('保存完成!');</script>");

function init_args(&$dbHandler)
{
  $iParams = array("apikey" => array(tlInputParameter::STRING_N,32,64),
                   "tproject_id" => array(tlInputParameter::INT_N), 
	          	   "tplan_id" => array(tlInputParameter::INT_N),
                   "build_id" => array(tlInputParameter::INT_N),
                   "device_id" => array(tlInputParameter::INT_N),
		           "format" => array(tlInputParameter::INT_N));

  $args = new stdClass();
  $pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) ){
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
    $cerbero->args->tplan_id = $args->tplan_id;
    $cerbero->args->build_id = $args->build_id;
    $cerbero->args->device_id = $args->device_id;
	
    if(strlen($args->apikey) == 32){
      $cerbero->args->getAccessAttr = true;
      $cerbero->method = 'checkRights';
      $cerbero->redirect_target = "../../login.php?note=logout";
      setUpEnvForRemoteAccess($dbHandler,$args->apikey,$cerbero);
    }
    else{
      $args->addOpAccess = false;
      $cerbero->method = null;
      setUpEnvForAnonymousAccess($dbHandler,$args->apikey,$cerbero);
    }  
  }
  else{
    testlinkInitPage($dbHandler,true,false,"checkRights");  
	  $args->tproject_id = isset($_SESSION['testprojectID']) ? intval($_SESSION['testprojectID']) : 0;
  }
 
  if($args->tproject_id <= 0){
  	$msg = __FILE__ . '::' . __FUNCTION__ . " :: Invalid Test Project ID ({$args->tproject_id})";
  	throw new Exception($msg);
  }

  if (is_null($args->format)){
		tlog("Parameter 'format' is not defined", 'ERROR');
		exit();
	}
	$args->user = $_SESSION['currentUser'];

  return $args;
}

function checkRights(&$db,&$user,$context = null){
  if(is_null($context)){
    $context = new stdClass();
    $context->tproject_id = $context->tplan_id = null;
    $context->getAccessAttr = false; 
  }

  $check = $user->hasRight($db,'testplan_metrics',$context->tproject_id,$context->tplan_id,$context->getAccessAttr);
  return $check;
}
?>