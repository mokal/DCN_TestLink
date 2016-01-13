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
$args->format = 0;
$args->tplan1 = $_GET['tplan1'];
$args->tplan2 = $_GET['tplan2'];
$args->device1 = $_GET['device1'];
$args->device2 = $_GET['device2'];

$args->stack1 = $_GET['stack1'];
$args->stack2 = $_GET['stack2'];
$args->total_build = 2;
$args->build[0] = $_GET['build1'] ;
$args->build[1] = $_GET['build2'] ;

if($args->tplan1==0 or $args->tplan2==0 or $args->build[0]==0 or $args->build[1]==0 or $args->device1==0 or $args->device2==0){
    echo "<script>alert('请先选择测试计划、产品型号和测试版本 对比源与目的！');</script>";
}else{

$tplan_mgr = new testplan($db);
$gui = initializeGui($db,$args,$tplan_mgr,$args->build_id);
$gui->do_report['status_ok'] = 1;
$gui->do_report['msg'] = '';
$gui->draw_string = "total=2" ;

$gui->tplan1 = $_GET['tplan1'];
$gui->tplan2 = $_GET['tplan2'];
$gui->device1 = $_GET['device1'];
$gui->device2 = $_GET['device2'];

$gui->stack1 = $_GET['stack1'];
$gui->stack2 = $_GET['stack2'];
$gui->total_build = 2;
$gui->build[0] = $_GET['build1'] ;
$gui->build[1] = $_GET['build2'] ;

$gui->build_name = array();
foreach($gui->build as $index=>$buildid){
	$j = $index + 1 ;
	$gui->build_name[$j] = $tplan_mgr->get_build_name_by_id($buildid);
}
	
$gui->tplan_tc1 = $tplan_mgr->get_device_tplan_for_build_compare($gui->tplan1,$gui->device1);
$gui->tplan_tc2 = $tplan_mgr->get_device_tplan_for_build_compare($gui->tplan2,$gui->device2);
$gui->tplan_tc = $gui->tplan_tc1 + $gui->tplan_tc2;

$gui->all_nopass = array();

$gui->buildnopass[0] = $tplan_mgr->get_build_nopass($gui->tplan1,$gui->build[0],$gui->device1,$gui->stack1);
$gui->buildallcase[0] = $tplan_mgr->get_build_all($gui->tplan1,$gui->build[0],$gui->device1,$gui->stack1);
$gui->buildnopass[1] = $tplan_mgr->get_build_nopass($gui->tplan2,$gui->build[1],$gui->device2,$gui->stack2);
$gui->buildallcase[1] = $tplan_mgr->get_build_all($gui->tplan2,$gui->build[1],$gui->device2,$gui->stack2);
$gui->draw_string .= "&1=" . count($gui->buildnopass[0]) . "&2=" . count($gui->buildnopass[1]) ;
$gui->draw_string .= "&name1=" . $gui->build_name[1] . "&name2=" . $gui->build_name[2];

if(array_keys($gui->buildnopass[0]) != null){
	$gui->all_nopass = array_merge($gui->all_nopass,array_keys($gui->buildnopass[0]));
}
if(array_keys($gui->buildnopass[1]) != null){
	$gui->all_nopass = array_merge($gui->all_nopass,array_keys($gui->buildnopass[1]));
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
	          "tplan1" => array(tlInputParameter::INT_N),
                    "device1" => array(tlInputParameter::INT_N),
		 "format" => array(tlInputParameter::INT_N));

  $args = new stdClass();
  $pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) ){
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
    $cerbero->args->tplan_id = $args->tplan1;
    $cerbero->args->device_id = $args->device1;
	
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