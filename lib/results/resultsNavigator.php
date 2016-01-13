<?php
/** 
 * TestLink Open Source Project - http://testlink.sourceforge.net/ 
 * This script is distributed under the GNU General Public License 2 or later. 
 *
 * Scope: Launcher for Test Results and Metrics.
 *
 * @filesource	resultsNavigator.php
 * @author      Martin Havlat <havlat@users.sourceforge.net>
 * 
 *
 * @internal revisions
 * @since 1.9.10
 * 
 **/
require('../../config.inc.php');
require_once('common.php');
require_once('reports.class.php');
testlinkInitPage($db,true,false,"checkRights");

$smarty = new TLSmarty();

$templateCfg = templateConfiguration();
$args = init_args();
$gui = initializeGui($db,$args);
$reports_mgr = new tlReports($db, $gui->tplan_id);

// -----------------------------------------------------------------------------
// Do some checks to understand if reports make sense

// Check if there are linked test cases to the choosen test plan.
$tc4tp_count = 1;//$reports_mgr->get_count_testcase4testplan();
tLog('TC in TP count = ' . $tc4tp_count);
if( $tc4tp_count == 0)
{
  // Test plan without test cases
  $gui->do_report['status_ok'] = 0;
  $gui->do_report['msg'] = lang_get('report_tplan_has_no_tcases');       
}

// Build qty
$build_count = 1;//$reports_mgr->get_count_builds();
tLog('Active Builds count = ' . $build_count);
if( $build_count == 0)
{
  // Test plan without builds can have execution data
  $gui->do_report['status_ok'] = 0;
  $gui->do_report['msg'] = lang_get('report_tplan_has_no_build');       
}

// -----------------------------------------------------------------------------
// get navigation data
$gui->menuItems = array();
if($gui->do_report['status_ok'])
{
  // create a list or reports
  $context = new stdClass();
  $context->tproject_id = $args->tproject_id;
  $context->tplan_id = $args->tplan_id;

  $tplan_mgr = new testplan($db);
  $dmy = $tplan_mgr->get_by_id($context->tplan_id);
  $gui->buildInfoSet = $tplan_mgr->get_builds($gui->tplan_id); 

  $report_plans = $tplan_mgr->report_get_plans($args->tproject_id);
  $report_suites = $tplan_mgr->report_get_suites($args->tproject_id);
  $report_builds = $tplan_mgr->report_get_builds(); 
  $report_build_total = count($report_builds);
  $report_devices = $tplan_mgr->report_get_devices($args->tproject_id); 
  $report_device_total = count($report_devices);

  unset($tplan_mgr);

  $context->apikey = $dmy['api_key'];
  // $context->apikey = $_SESSION['currentUser']->userApiKey;
  $context->imgSet = $smarty->getImages();
  $gui->menuItems = $reports_mgr->get_list_reports($context,$gui->btsEnabled,$args->optReqs, 
                                                   $tlCfg->reports_formats[$args->format]);
}

$smarty->assign('gui', $gui);
$smarty->assign('report_plans',$report_plans );
$smarty->assign('report_suites',$report_suites );
$smarty->assign('report_builds', json_encode($report_builds) ); 
$smarty->assign('report_build_total', $report_build_total );
$smarty->assign('report_devices', json_encode($report_devices) ); 
$smarty->assign('report_device_total', $report_device_total );


$smarty->assign('arrReportTypes', localize_array($tlCfg->reports_formats));
$smarty->assign('selectedReportType', $args->format);
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

/**
 * 
 *
 */
function init_args()
{
  $iParams = array("format" => array(tlInputParameter::INT_N),
                   "tplan_id" => array(tlInputParameter::INT_N),
                   "show_inactive_tplans" => array(tlInputParameter::CB_BOOL));
  $args = new stdClass();
  R_PARAMS($iParams,$args);
  
  if (is_null($args->format))
  {
    $reports_formats = config_get('reports_formats');
    $args->format = sizeof($reports_formats) ? key($reports_formats) : null;
  }
  
  if (is_null($args->tplan_id))
  {
    $args->tplan_id = $_SESSION['testplanID'];
  }
  
  $_SESSION['resultsNavigator_testplanID'] = $args->tplan_id;
  $_SESSION['resultsNavigator_format'] = $args->format;
  
  $args->tproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
  $args->userID = $_SESSION['userID'];
  $args->user = $_SESSION['currentUser'];
  $args->optReqs = $_SESSION['testprojectOptions']->requirementsEnabled;
  $args->checked_show_inactive_tplans = $args->show_inactive_tplans ? 'checked="checked"' : 0;
  $args->show_only_active_tplans = !$args->show_inactive_tplans;
    
  return $args;
}

function initializeGui(&$dbHandler,$argsObj)
{
  $gui = new stdClass();
  
  $gui->workframe = $_SESSION['basehref'] . "lib/general/staticPage.php?key=showMetrics";
  $gui->do_report = array('status_ok' => 1, 'msg' => '');
  $gui->tplan_id = $argsObj->tplan_id;
  $gui->tproject_id = $argsObj->tproject_id;
  $gui->checked_show_inactive_tplans = $argsObj->checked_show_inactive_tplans;
  
  $tproject_mgr = new testproject($dbHandler);
  $gui->btsEnabled = $tproject_mgr->isIssueTrackerEnabled($gui->tproject_id);
  
  // get Accessible Test Plans for combobox
  $activeAttr = $argsObj->show_only_active_tplans ? 1 : null;
  $gui->tplans = $argsObj->user->getAccessibleTestPlans($dbHandler,$argsObj->tproject_id,null,
                                                        array('output' =>'combo', 'active' => $activeAttr));
  
  return $gui;
}



/**
 * 
 *
 */
function checkRights(&$db,&$user)
{
  return $user->hasRight($db,'testplan_metrics');
}
?>
