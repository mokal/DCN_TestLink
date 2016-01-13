<?php
/** 
 * @author	guomf
 * Show Test Results
 */
require('../../config.inc.php');
require_once('common.php');
require_once('displayMgr.php');

$timerOn = microtime(true);
$templateCfg = templateConfiguration();

$args = init_args($db);
$args->tplan_id = $_GET['tplan_id'];
$args->device_id = $_GET['device_id'];
$args->format = 0;
$args->stack = $_GET['stack'];
$args->total_build = $_GET['totalbuild'];
for( $i=0 ; $i < $args->total_build ; $i++ ){
    $args->build[$i] = $_GET['build' . $i] ;
}


if($args->tplan_id == 0 or $args->total_build == 0 or $args->total_build == 1 or $args->device_id == 0){
    echo "<script>alert('请先选择项目测试计划、测试产品型号和测试版本信息！版本至少需要选择2个！');</script>";
}else{

$tplan_mgr = new testplan($db);
$gui = initializeGui($db,$args,$tplan_mgr,$args->build_id);
$gui->do_report['status_ok'] = 1;
$gui->do_report['msg'] = '';

$gui->productline_id = $args->tproject_id;
$gui->tplan_id = $args->tplan_id;
$gui->device_id = $args->device_id;
$gui->stack = $args->stack;
$gui->total_build = $args->total_build;
$gui->build = $args->build;

sort($gui->build);

$gui->build_total = count($gui->build);
$gui->build_name = array();
foreach($gui->build as $index=>$buildid){
	$j = $index + 1 ;
	$gui->build_name[$j] = $tplan_mgr->get_build_name_by_id($buildid);
}
	
$gui->tplan_tc = $tplan_mgr->get_device_tplan_for_build_compare($gui->tplan_id,$gui->device_id);

$gui->all_nopass = array();
$gui->draw_string = "total=" . $gui->total_build ;
for( $i=0; $i<$args->total_build ; $i++ ){
  $gui->buildnopass[$i] = $tplan_mgr->get_build_nopass($gui->tplan_id,$gui->build[$i],$gui->device_id,$gui->stack);
  $gui->buildallcase[$i] = $tplan_mgr->get_build_all($gui->tplan_id,$gui->build[$i],$gui->device_id,$gui->stack);
  $j = $i + 1 ;

  if($gui->buildnopass[$i] != null){
  	$gui->all_nopass = array_merge($gui->all_nopass,array_keys($gui->buildnopass[$i]));
  	$gui->draw_string .=  "&" . $j . "=" . count($gui->buildnopass[$i]) ;
  }else{
  	$gui->draw_string .=  "&" . $j . "=0";
  }
}
$gui->all_nopass = array_unique($gui->all_nopass);

$smarty = new TLSmarty;
$smarty->assign('gui', $gui);
displayReport($templateCfg->template_dir . $templateCfg->default_template, $smarty, $args->format);
}
function init_args(&$dbHandler)
{
  $iParams = array("apikey" => array(tlInputParameter::STRING_N,32,64),
                   "tproject_id" => array(tlInputParameter::INT_N), 
	          "tplan_id" => array(tlInputParameter::INT_N),
                    "device_id" => array(tlInputParameter::INT_N),
		 "format" => array(tlInputParameter::INT_N));

  $args = new stdClass();
  $pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) ){
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
    $cerbero->args->tplan_id = $args->tplan_id;
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