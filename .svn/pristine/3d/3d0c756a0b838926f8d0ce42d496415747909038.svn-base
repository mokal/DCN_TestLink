<?php
require_once("../../config.inc.php");
require_once("common.php");

list($args,$gui) = initEnv($db);

$templateCfg = templateConfiguration($args->job_id);
$smarty = new TLSmarty();
$default_template = $templateCfg->default_template;

$op = new stdClass();

$platform_mgr = new tlPlatform($db, $args->testproject_id);


$gui->jobdetails = $platform_mgr->getSpecialJob($_GET['id']);

$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);


function initEnv(&$dbHandler)
{
  testlinkInitPage($dbHandler);
  $argsObj = init_args();

  $guiObj = init_gui($dbHandler,$argsObj);

  return array($argsObj,$guiObj);
}

function init_args()
{
  $_REQUEST = strings_stripSlashes($_REQUEST);

  $args = new stdClass();
  $source = sizeof($_POST) ? "POST" : "GET";
  $iParams = array("doAction" => array($source,tlInputParameter::STRING_N,0,50));
  $pParams = I_PARAMS($iParams);
  
  $args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
  $args->testproject_name = isset($_SESSION['testprojectName']) ? $_SESSION['testprojectName'] : 0;
  $args->currentUser = $_SESSION['currentUser'];
  
  return $args;
}

function init_gui(&$db,&$args)
{
  $gui = new stdClass();
  $gui->user_feedback = array('type' => 'INFO', 'message' => '');
    
  return $gui;
}

function checkPageAccess(&$db,&$argsObj)
{
  $env['script'] = basename(__FILE__);
  $env['tproject_id'] = isset($argsObj->testproject_id) ? $argsObj->testproject_id : 0;
  $env['tplan_id'] = isset($argsObj->tplan_id) ? $argsObj->tplan_id : 0;
  $argsObj->currentUser->checkGUISecurityClearance($db,$env,array('platform_management'),'and');
}
