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
$args->tplan_id = $_GET['tplan_id'];
$args->build_id = $_GET['build_id'];
$args->device_id = $_GET['device_id'];
$args->format = 0;
$args->stack = isset($_GET['stack'])? $_GET['stack'] : 0;

if($args->tplan_id == 0 or $args->build_id == 0 or $args->device_id == 0){
    echo "<script>alert('请先选择项目测试计划、测试产品型号和测试版本信息！');</script>";
}else{

$tplan_mgr = new testplan($db);
$gui = initializeGui($db,$args,$tplan_mgr,$args->build_id);

$gui->do_report['status_ok'] = 1;
$gui->do_report['msg'] = '';
$gui->productline_id = $args->tproject_id;
$gui->tplan_id = $args->tplan_id;
$gui->build_id = $args->build_id;
$gui->device_id = $args->device_id;
$gui->needstack = $args->stack;
$gui->build_by_id = $tplan_mgr->get_build_by_id($args->tplan_id,$args->build_id);
$gui->suites = $tplan_mgr->get_all_suites();
$platformSet = $tplan_mgr->getPlatforms($args->tplan_id,array('outputFormat' => 'map'));
if( $args->build_id != 1 && $gui->needstack == 0){
    $gui->build_result = $tplan_mgr->get_build_result($args->build_id,$gui->device_id);
    $gui->build_result_summary = $tplan_mgr->get_build_result_summary($args->build_id,$gui->device_id);
    $gui->build_reviewer = $tplan_mgr->get_build_reviewer($args->build_id,$gui->device_id);
    $gui->build_review_summary = $tplan_mgr->get_build_review_summary($args->build_id,$gui->device_id);
    $gui->build_timePoint = $tplan_mgr->get_build_timePoint($args->build_id);
}

if($args->device_id == '1'){
    $gui->alldevice = $platformSet;
	foreach($platformSet as $device_id=>$device_name){
		//$gui->tplan_tc[$device_id] = $tplan_mgr->get_device_tplan_tc($args->tplan_id,$device_id);
		$gui->results[$device_id] = $tplan_mgr->get_device_build_exec($args->tplan_id,$args->build_id,$device_id,$args->stack);
	}
}else{
	$gui->alldevice = array($args->device_id=>$platformSet[$args->device_id]);
	//$gui->tplan_tc[$args->device_id] = $tplan_mgr->get_device_tplan_tc($args->tplan_id,$args->device_id);
	$gui->results[$args->device_id] = $tplan_mgr->get_device_build_exec($args->tplan_id,$args->build_id,$args->device_id,$args->stack);
}

$gui->stackloop = array(1=>'0',2=>'0',3=>'0',4=>'0');
$smarty = new TLSmarty;
$smarty->assign('gui', $gui);
$smarty->assign('tplan', $_GET['tplan_id']);
$smarty->assign('build', $_GET['build_id']);
$smarty->assign('mystack', $args->stack);

displayReport($templateCfg->template_dir . $templateCfg->default_template, $smarty, $args->format);
}
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

function initializeGui(&$dbHandler,$argsObj,&$tplanMgr,$buildid){
  $gui = new stdClass();
  $gui->title = lang_get('title_gen_test_rep');
  $gui->do_report = array();
  
  $gui->elapsed_time = 0; 

  $mgr = new testproject($dbHandler);
  $dummy = $mgr->get_by_id($argsObj->tproject_id);
  $gui->testprojectOptions = new stdClass();
  $gui->testprojectOptions->testPriorityEnabled = $dummy['opt']->testPriorityEnabled;
  $gui->tproject_name = $dummy['name'];
  
  $info = $tplanMgr->get_by_id($argsObj->tplan_id);
  $gui->tplan_name = $info['name'];

  return $gui;
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