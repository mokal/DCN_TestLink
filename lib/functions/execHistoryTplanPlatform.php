<?php
require_once('../../config.inc.php');
require_once('common.php');
require_once('exec.inc.php');
require_once("attachments.inc.php");
require_once("web_editor.php");

testlinkInitPage($db);
$templateCfg = templateConfiguration();

$tcase_mgr = new testcase($db);
$args = init_args();
$gui = new stdClass();
$gui->exec_cfg = config_get('exec_cfg');

$node['basic'] = $tcase_mgr->tree_manager->get_node_hierarchy_info($args->tcase_id); 
$node['specific'] = $tcase_mgr->getExternalID($args->tcase_id); 
$idCard = $node['specific'][0] . ' : ' . $node['basic']['name'];

$gui->tproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;

$gui->execSet = $tcase_mgr->getExecutionSetTplanPlatform($args->tplan_id,$args->device_id,$args->tcase_id);
//retuen 
$gui->warning_msg = (!is_null($gui->execSet)) ? '' : lang_get('tcase_never_executed');
$gui->user_is_admin = ($args->user->globalRole->name=='admin') ? true : false;

$gui->execPlatformSet = null;
$gui->cfexec = null;
$gui->attachments = null;

$gui->main_descr = lang_get('execution_history');
$gui->detailed_descr = lang_get('test_case') . ' ' . $idCard;
$smarty = new TLSmarty();
$smarty->assign('gui',$gui);  
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

function init_args()
{
  $args = new stdClass();
  $_REQUEST = strings_stripSlashes($_REQUEST);
  $iParams = array("tplan_id" => array(tlInputParameter::INT_N),
                   "device_id" => array(tlInputParameter::INT_N),
                   "tcase_id" => array(tlInputParameter::INT_N));
  $pParams = R_PARAMS($iParams);

  $args = new stdClass();
  $args->tplan_id = intval($pParams["tplan_id"]);
  $args->build_id = intval($pParams["build_id"]);
  $args->device_id = intval($pParams["device_id"]);
  $args->tcase_id = intval($pParams["tcase_id"]);
  
  $args->user = $_SESSION['currentUser'];
  return $args;
}