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
$args->tplan_id = $_GET['tplan'];
$args->data_type = $_GET['type'];
$args->suite_id = $_GET['suite'];
$args->data_type_name = $_GET['typename'];

$args->format = 0;
$tplan_mgr = new testplan($db);

$gui = initializeGui($db,$args,$tplan_mgr);
$gui->do_report['status_ok'] = 1;
$gui->do_report['msg'] = '';

$gui->productline_id = $args->tproject_id;
$gui->tplan_id = $args->tplan_id;
$gui->suite_id = $args->suite_id;
$gui->data_type = $args->data_type;
$gui->data_type_name = $args->data_type_name;

if($gui->data_type != 4){
	$gui->tplan_tc = $tplan_mgr->get_tpan_tc_for_topn($gui->tplan_id);
	$gui->allcase = $tplan_mgr->get_tpan_allcase_count($gui->tplan_id);
}

$gui->topn = $tplan_mgr->get_tplan_topn($gui->productline_id,$gui->tplan_id,$gui->suite_id,$gui->data_type);

$smarty = new TLSmarty;
$smarty->assign('gui', $gui);
displayReport($templateCfg->template_dir . $templateCfg->default_template, $smarty, $args->format);

function init_args(&$dbHandler)
{
  $iParams = array("apikey" => array(tlInputParameter::STRING_N,32,64),
                   "tproject_id" => array(tlInputParameter::INT_N), 
		           "format" => array(tlInputParameter::INT_N));

  $args = new stdClass();
  $pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) ){
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
	
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

function initializeGui(&$dbHandler,$argsObj,&$tplanMgr){
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
  return True;
}
?>