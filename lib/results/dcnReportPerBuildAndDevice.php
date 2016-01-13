<?php
/** 
 * @author	guomf
 * Show Test Results as ower affirm format.
 */
require('../../config.inc.php');
require_once('common.php');
require_once('displayMgr.php');

$build_id = isset($_COOKIE['build_id']) ? intval($_COOKIE['build_id']) : 0 ;

if($build_id > 0){

$timerOn = microtime(true);
$templateCfg = templateConfiguration();

$args = init_args($db);
$tplan_mgr = new testplan($db);

$gui = initializeGui($db,$args,$tplan_mgr,$build_id);
$mailCfg = buildMailCfg($gui);

$gui->do_report['status_ok'] = 1;
$gui->do_report['msg'] = '';
$gui->tplan_id = $args->tplan_id;
$gui->build_id = $build_id;
$gui->build_by_id = $tplan_mgr->get_build_by_id($args->tplan_id,$build_id);

// 以"售后维护-"开头的testplan是售后项目，将被过滤没有执行记录的设备型号
if(preg_match("/(售后维护-)/u",$gui->tplan_name)){
  $gui->platformSet = $tplan_mgr->getPlatformsHasExecuted($args->tplan_id,$build_id, array('outputFormat' => 'map'));
}
else{
  $gui->platformSet = $tplan_mgr->getPlatforms($args->tplan_id,array('outputFormat' => 'map'));
}
$gui->platformSet_flip = array_flip($gui->platformSet);
$gui->result_total = $gui->result_pass = $gui->result_fail = $gui->result_na = $gui->result_skip = $gui->result_warn = $gui->result_block = $gui->result_notrun = $gui->result_accept = array() ;
if( !is_null($gui->platformSet) )
{
    $gui->testresults = array();
    foreach($gui->platformSet_flip as $deviceid){
       $gui->testresults[$deviceid] = $tplan_mgr->get_exec_device($args->tplan_id,$build_id,$deviceid);
       $gui->result_total[$deviceid] = count($gui->testresults[$deviceid]);
       foreach($gui->testresults[$deviceid] as $index){
                 switch($index['status']){
                     case "Pass" :
                               $gui->result_pass[$deviceid]  = $gui->result_pass[$deviceid] + 1;
                               break;
                     case "Failed" :
                               $gui->result_fail[$deviceid]  = $gui->result_fail[$deviceid]  + 1;
                               break;
                     case "Skip" :
                               $gui->result_skip[$deviceid]  = $gui->result_skip[$deviceid]  + 1;
                               break;
                     case "Block" :
                               $gui->result_block[$deviceid]  = $gui->result_block[$deviceid]  + 1;
                               break;
                     case "NOT RUN" :
                               $gui->result_notrun[$deviceid]  = $gui->result_notrun[$deviceid]  + 1;
                               break;
                     case "N/A" :
                               $gui->result_na[$deviceid]  = $gui->result_na[$deviceid]  + 1;
                               break;
                     case "Warn" :
                               $gui->result_warn[$deviceid]  = $gui->result_warn[$deviceid]  + 1;
                               break;
                     case "Accept" :
                               $gui->result_accept[$deviceid]  = $gui->result_accept[$deviceid]  + 1;
                               break;
                    default:
                              break;
                 }
             }
        $gui->result_total[$deviceid] = !is_null( $gui->result_total[$deviceid]) ?  $gui->result_total[$deviceid] : 0 ;
        $gui->result_pass[$deviceid] = !is_null($gui->result_pass[$deviceid]) ?  $gui->result_pass[$deviceid] : 0 ;
        $gui->result_fail[$deviceid] = !is_null($gui->result_fail[$deviceid]) ?  $gui->result_fail[$deviceid] : 0 ;
        $gui->result_skip[$deviceid] = !is_null($gui->result_skip[$deviceid]) ?  $gui->result_skip[$deviceid] : 0 ;
        $gui->result_block[$deviceid] = !is_null($gui->result_block[$deviceid]) ?  $gui->result_block[$deviceid] : 0 ;
        $gui->result_notrun[$deviceid] = !is_null($gui->result_notrun[$deviceid]) ?  $gui->result_notrun[$deviceid] : 0 ;
        $gui->result_na[$deviceid] = !is_null($gui->result_na[$deviceid]) ?  $gui->result_na[$deviceid] : 0 ;
        $gui->result_warn[$deviceid] = !is_null($gui->result_warn[$deviceid]) ?  $gui->result_warn[$deviceid] : 0 ;
        $gui->result_accept[$deviceid] = !is_null($gui->result_accept[$deviceid]) ?  $gui->result_accept[$deviceid] : 0 ;

       // $gui->test_env[$deviceid] = $tplan_mgr->get_exec_env($build_id,$deviceid);
      }
}
$tempa = $tplan_mgr->get_build_testresult($build_id);
$tempb = $tplan_mgr->get_build_resultsummary($build_id);
$gui->testresult = !is_null($tempa)? htmlspecialchars($tempa['value']):'<span style="color:#E53333">版本测试结果未分析</span>';
$gui->resultsummary = !is_null($tempa)? htmlspecialchars_decode($tempb['value']):'';
unset($tempa);
unset($tempb);

$gui->test_topo = '/affirm2.png';
$time = $tplan_mgr->get_build_timePoint($build_id);

$gui->buildStartTime = !is_null($time['release_date']) ? $time['release_date'] : $time['creation_ts'] ;
$gui->buildEndTime = !is_null($time['closed_on_date']) ? $time['closed_on_date'] : 'Build NOT CLOSED';
unset($time);

$timerOff = microtime(true);
$gui->elapsed_time = round($timerOff - $timerOn,2);
$smarty = new TLSmarty;
$smarty->assign('gui', $gui);
displayReport($templateCfg->template_dir . $templateCfg->default_template, $smarty, $args->format,$mailCfg);

}
else #no build selected
{
	echo "<script>alert('报告基于版本测试结果，请先选择版本信息!');</script>";
}
/*
  function: init_args 
  args: none
  returns: array 
*/
function init_args(&$dbHandler)
{
  $iParams = array("apikey" => array(tlInputParameter::STRING_N,32,64),
                   "tproject_id" => array(tlInputParameter::INT_N), 
	          "tplan_id" => array(tlInputParameter::INT_N),
                   "build_id" => array(tlInputParameter::INT_N),
		 "format" => array(tlInputParameter::INT_N));

	$args = new stdClass();
	$pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) )
  {
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
    $cerbero->args->tplan_id = $args->tplan_id;
	
    if(strlen($args->apikey) == 32)
    {
      $cerbero->args->getAccessAttr = true;
      $cerbero->method = 'checkRights';
      $cerbero->redirect_target = "../../login.php?note=logout";
      setUpEnvForRemoteAccess($dbHandler,$args->apikey,$cerbero);
    }
    else
    {
      $args->addOpAccess = false;
      $cerbero->method = null;
      setUpEnvForAnonymousAccess($dbHandler,$args->apikey,$cerbero);
    }  
  }
  else
  {
    testlinkInitPage($dbHandler,true,false,"checkRights");  
	  $args->tproject_id = isset($_SESSION['testprojectID']) ? intval($_SESSION['testprojectID']) : 0;
  }
 
  if($args->tproject_id <= 0)
  {
  	$msg = __FILE__ . '::' . __FUNCTION__ . " :: Invalid Test Project ID ({$args->tproject_id})";
  	throw new Exception($msg);
  }

  if (is_null($args->format))
	{
		tlog("Parameter 'format' is not defined", 'ERROR');
		exit();
	}
	
	$args->user = $_SESSION['currentUser'];

  return $args;
}

/**
 * 
 *
 */
function buildMailCfg(&$guiObj)
{
	$labels = array('testplan' => lang_get('testplan'), 'testproject' => lang_get('testproject'));
	$cfg = new stdClass();
	$cfg->cc = ''; 
	$cfg->subject = $guiObj->title . ' : ' . $labels['testproject'] . ' : ' . $guiObj->tproject_name . 
	                ' : ' . $labels['testplan'] . ' : ' . $guiObj->tplan_name;
	                 
	return $cfg;
}


function initializeGui(&$dbHandler,$argsObj,&$tplanMgr,$buildid)
{
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

function checkRights(&$db,&$user,$context = null)
{
  if(is_null($context))
  {
    $context = new stdClass();
    $context->tproject_id = $context->tplan_id = null;
    $context->getAccessAttr = false; 
  }

  $check = $user->hasRight($db,'testplan_metrics',$context->tproject_id,$context->tplan_id,$context->getAccessAttr);
  return $check;
}

?>