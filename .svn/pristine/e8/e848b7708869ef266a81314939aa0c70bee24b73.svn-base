<?php
/**
 * TestLink Open Source Project - http://testlink.sourceforge.net/ 
 * This script is distributed under the GNU General Public License 2 or later. 
 *
 * @filesource  platformsEdit.php
 * @package     TestLink
 * @copyright   2009-2013, TestLink community 
 * @link        http://www.teamst.org/index.php
 *
 * allows users to manage platforms. 
 *
 * @internal revisions
 *
**/
require_once("../../config.inc.php");
require_once("common.php");
require_once("csv.inc.php");
require_once("xml.inc.php");

require_once("web_editor.php");
$editorCfg = getWebEditorCfg('build');
require_once(require_web_editor($editorCfg['type']));

// Security checks are done, if failed => exit()
list($args,$gui) = initEnv($db);

$templateCfg = templateConfiguration();
$smarty = new TLSmarty();
$default_template = $templateCfg->default_template;

$op = new stdClass();
$op->status = 0;

$of = web_editor('notes',$_SESSION['basehref'],$editorCfg);
$of->Value = getItemTemplateContents('platform_template', $of->InstanceName, $args->notes);


$platform_mgr = new tlPlatform($db, $args->testproject_id);

$action = $args->doAction;
switch ($action)
{
  case "do_create":
  case "do_update":
  case "do_delete":
    if (!$gui->canManage)
    {
      break;
    }
      
  case "edit":
  case "create":
    $op = $action($args,$gui,$platform_mgr);
    $of->Value = $gui->notes;
  break;
}

if($op->status == 1)
{
  $default_template = $op->template;
  $gui->user_feedback['message'] = $op->user_feedback;
}
else
{
  $gui->user_feedback['message'] = getErrorMessage($op->status, $args->name);
  $gui->user_feedback['type'] = 'ERROR';
}
$gui->platforms = $platform_mgr->getAll(array('include_linked_count' => true));
$gui->vars = $platform_mgr->getAllVars();
$gui->notes = $of->CreateHTML();
$gui->allPerformance = $platform_mgr->getAllPerformance();

$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $default_template);



/**
 * 
 *
 */
function initEnv(&$dbHandler)
{
  testlinkInitPage($dbHandler);
  $argsObj = init_args();
  checkPageAccess($dbHandler,$argsObj);  // Will exit if check failed

  $guiObj = init_gui($dbHandler,$argsObj);

  return array($argsObj,$guiObj);
}



/**
 * 
 *
 */
function init_args()
{
  $_REQUEST = strings_stripSlashes($_REQUEST);

  $args = new stdClass();
  $source = sizeof($_POST) ? "POST" : "GET";
  $iParams = array("doAction" => array($source,tlInputParameter::STRING_N,0,50),
                   "id" => array($source, tlInputParameter::INT_N),
                   "name" => array($source, tlInputParameter::STRING_N,0,100),
				   "supportl3" => array($source, tlInputParameter::INT_N),
				   "isboxswitch" => array($source, tlInputParameter::INT_N),
				   "linespeed" => array($source, tlInputParameter::INT_N),
  		           "affirm2devicegroup" => array($source, tlInputParameter::INT_N),
  		           "affirm3devicegroup" => array($source, tlInputParameter::INT_N),
  		           "functiondevicegroup" => array($source, tlInputParameter::INT_N),
  		           "performance_id" => array($source, tlInputParameter::INT_N),
                   "notes" => array($source, tlInputParameter::STRING_N));
    
  $pParams = I_PARAMS($iParams);

  $args->doAction = $pParams["doAction"];
  $args->platform_id = $pParams["id"];
  $args->name = $pParams["name"];
  $args->notes = $pParams["notes"];

  // why we need this logic ????
  if ($args->doAction == "edit")
  {
    $_SESSION['platform_id'] = $args->platform_id;
  }
  else if($args->doAction == "do_update")
  {
    $args->platform_id = $_SESSION['platform_id'];
  }
  
  $args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
  $args->testproject_name = isset($_SESSION['testprojectName']) ? $_SESSION['testprojectName'] : 0;
  $args->currentUser = $_SESSION['currentUser'];
  
  
  return $args;
}

/*
  function: create
            initialize variables to launch user interface (smarty template)
            to get information to accomplish create task.

  args:
  
  returns: - 

*/
function create(&$args,&$gui)
{
  $ret = new stdClass();
  $ret->template = 'platformsEdit.tpl';
  $ret->status = 1;
  $ret->user_feedback = '';
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_create';
  $gui->action_descr = lang_get('create_platform');
  
  return $ret;
}


/*
  function: edit
            initialize variables to launch user interface (smarty template)
            to get information to accomplish edit task.

  args:
  
  returns: - 

*/
function edit(&$args,&$gui,&$platform_mgr)
{
  $ret = new stdClass();
  $ret->template = 'platformsEdit.tpl';
  $ret->status = 1;
  $ret->user_feedback = '';

  $gui->action_descr = lang_get('edit_platform');
  $platform = $platform_mgr->getById($args->platform_id);
  if ($platform)
  {
    $args->name = $platform['name'];
    $args->notes = $platform['notes'];
    $args->supportl3 = $platform['supportl3'];  
    $args->affirm2devicegroup = $platform['affirm2_var'];
    $args->affirm3devicegroup = $platform['affirm3_var'];
    $args->functiondevicegroup = $platform['function_var'];
    $args->isboxswitch = $platform['isboxswitch'];
    $args->linespeed = $platform['linespeed'];
    $args->performance_id = $platform['performance_id'];
     
    $gui->name = $args->name;
    $gui->supportl3 = $args->supportl3;
    $gui->affirm2devicegroup = $args->affirm2devicegroup;
    $gui->affirm3devicegroup = $args->affirm3devicegroup;
    $gui->functiondevicegroup = $args->functiondevicegroup;
    $gui->isboxswitch = $args->isboxswitch;
    $gui->linespeed = $args->linespeed;
    $gui->performance_id = $args->performance_id;
	
	$gui->notes = $args->notes;
    $gui->action_descr .= TITLE_SEP . $platform['name'];
  }
  
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->main_descr = lang_get('platform_management');
  
  return $ret;
}

/*
  function: do_create 
            do operations on db

  args :
  
  returns: 

*/
function do_create(&$args,&$gui,&$platform_mgr)
{
  $gui->main_descr = lang_get('platform_management');
  $gui->action_descr = lang_get('create_platform');
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_create';

  $ret = new stdClass();
  $ret->template = 'platformsView.tpl';

  $op = $platform_mgr->create($args->name,$_POST['supportl3'], $_POST['isboxswitch'], $_POST['linespeed'],$_POST['affirm2devicegroup'],$_POST['affirm3devicegroup'],$_POST['functiondevicegroup'], $_POST['performance_id'],$args->notes);
  $ret->status = $op['status']; 
  $ret->user_feedback = sprintf(lang_get('platform_created'), $args->name);
  
  return $ret;
}

/*
  function: do_update
            do operations on db

  args :
  
  returns: 

*/
function do_update(&$args,&$gui,&$platform_mgr)
{
  $action_descr = lang_get('edit_platform');
  $platform = $platform_mgr->getPlatform($args->platform_id);
  if ($platform)
  {
    $action_descr .= TITLE_SEP . $platform['name'];
    }
    
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->main_descr = lang_get('platform_management');
  $gui->action_descr = $action_descr;

  $ret = new stdClass();
  $ret->template = 'platformsView.tpl';
  $ret->status = $platform_mgr->update($args->platform_id,$args->name, $_POST['supportl3'], $_POST['isboxswitch'], $_POST['linespeed'], $_POST['affirm2devicegroup'],$_POST['affirm3devicegroup'],$_POST['functiondevicegroup'],$_POST['performance_id'], $args->notes);
  $ret->user_feedback = sprintf(lang_get('platform_updated'), $args->name);

  return $ret;
}

/*
  function: do_delete
            do operations on db

  args :
  
  returns: 

*/
function do_delete(&$args,&$gui,&$platform_mgr)
{
  $gui->main_descr = lang_get('testproject') . TITLE_SEP . $args->testproject_name;

  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->action_descr = lang_get('edit_platform');

  $ret = new stdClass();
  $ret->template = 'platformsView.tpl';
  // This also removes all exec data on this platform
  $ret->status = $platform_mgr->delete($args->platform_id,true);
  $ret->user_feedback = sprintf(lang_get('platform_deleted'), $args->name);

  return $ret;
}


function getErrorMessage($code,$platform_name)
{
  switch($code)
  {
    case tlPlatform::E_NAMENOTALLOWED:
      $msg = lang_get('platforms_char_not_allowed'); 
      break;

    case tlPlatform::E_NAMELENGTH:
      $msg = lang_get('empty_platform_no');
      break;

    case tlPlatform::E_DBERROR:
    case ERROR: 
      $msg = lang_get('platform_update_failed');
      break;

    case tlPlatform::E_NAMEALREADYEXISTS:
      $msg = sprintf(lang_get('platform_name_already_exists'),$platform_name);
      break;

    default:
      $msg = 'ok';
  }
  return $msg;
}

/**
 *
 */
function init_gui(&$db,&$args)
{
  $gui = new stdClass();
  $gui->canManage = $args->currentUser->hasRight($db,"platform_management");
  $gui->mgt_view_events = $args->currentUser->hasRight($db,"mgt_view_events");
  $gui->user_feedback = array('type' => 'INFO', 'message' => '');
  $gui->name = $args->name;
  $gui->notes = $args->notes;
  $gui->platformID = $args->platform_id;
    
  return $gui;
}

/**
 *
 */
function checkPageAccess(&$db,&$argsObj)
{
  $env['script'] = basename(__FILE__);
  $env['tproject_id'] = isset($argsObj->testproject_id) ? $argsObj->testproject_id : 0;
  $env['tplan_id'] = isset($argsObj->tplan_id) ? $argsObj->tplan_id : 0;
  $argsObj->currentUser->checkGUISecurityClearance($db,$env,array('platform_management'),'and');
}
