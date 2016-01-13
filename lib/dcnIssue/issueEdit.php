<?php
require_once("../../config.inc.php");
require_once("common.php");

require_once("web_editor.php");
$editorCfg = getWebEditorCfg('build');
require_once(require_web_editor($editorCfg['type']));

list($args,$gui) = initEnv($db);

$templateCfg = templateConfiguration();
$smarty = new TLSmarty();
$default_template = $templateCfg->default_template;

$op = new stdClass();
$op->status = 0;

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$action = $args->doAction;
switch ($action)
{
  case "do_create":
  case "do_update":
  case "do_delete":     
  case "edit":
  case "create":
    $op = $action($args,$gui,$platform_mgr);
  break;
}

if($op->status == 1)
{
  $default_template = $op->template;
  $gui->user_feedback['message'] = $op->user_feedback;
}
else
{
  $gui->user_feedback['message'] = getErrorMessage($op->status, $args->testcase);
  $gui->user_feedback['type'] = 'ERROR';
}
$gui->issues = $platform_mgr->getAllIssue();

$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $default_template);


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
  $iParams = array("doAction" => array($source,tlInputParameter::STRING_N,0,50),
                   "id" => array($source, tlInputParameter::INT_N),
                   "testcase" => array($source, tlInputParameter::STRING_N,0,100),
				   "step" => array($source, tlInputParameter::STRING_N,0,50),
				   "product" => array($source, tlInputParameter::STRING_N,0,100),
				   "script" => array($source, tlInputParameter::STRING_N,0,50),
                   "comment" => array($source, tlInputParameter::STRING_N));
  $pParams = I_PARAMS($iParams);

  $args->doAction = $pParams["doAction"];
  $args->issue_id = $pParams["id"];
  $args->testcase = $pParams["testcase"];
  $args->step = $pParams["step"];
  $args->product = $pParams["product"];
  $args->script = $pParams["script"];
  $args->comment = $pParams["comment"];

  if ($args->doAction == "edit")
  {
    $_SESSION['issue_id'] = $args->issue_id;
  }
  else if($args->doAction == "do_update")
  {
    $args->issue_id = $_SESSION['issue_id'];
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
  $ret->template = 'issueEdit.tpl';
  $ret->status = 1;
  $ret->user_feedback = '';
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_create';
  $gui->action_descr = '添加已知缺陷';
  
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
  $ret->template = 'issueEdit.tpl';
  $ret->status = 1;
  $ret->user_feedback = '';

  $gui->action_descr = '编辑已知缺陷';
  $issue = $platform_mgr->getIssueById($args->issue_id);
  
  if ($issue)
  {
    $args->testcase = $issue['testcase'];
    $args->step = $issue['failedsteps'];
    $args->product = $issue['product'];
    $args->script = $issue['script_version'];
    $args->comment = $issue['comment'];

    $gui->testcase = $args->testcase;
    $gui->step = $args->step;
    $gui->product = $args->product;
    $gui->script = $args->script;
    $gui->comment = $args->comment;
	
    $gui->action_descr .= TITLE_SEP . $issue['testcase'];
  }
  
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->main_descr = '已知缺陷管理';
  
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
  $gui->main_descr = '已知缺陷管理';
  $gui->action_descr = '添加已知缺陷';
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_create';

  $ret = new stdClass();
  $ret->template = 'issueView.tpl';
  $op = $platform_mgr->createIssue($args->testcase,$args->step,$args->product,$args->script,$args->comment);
  $ret->status = $op['status']; 
  $ret->user_feedback = sprintf('已知缺陷添加成功', $args->testcase);
  
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
  $action_descr = '编辑已知缺陷';
  $issue = $platform_mgr->getIssue($args->issue_id);
  if ($issue)
  {
    $action_descr .= TITLE_SEP . $issue['testcase'];
    }
    
  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->main_descr = '已知缺陷管理';
  $gui->action_descr = $action_descr;

  $ret = new stdClass();
  $ret->template = 'issueView.tpl';
  $ret->status = $platform_mgr->updateIssue($args->issue_id,$args->testcase,$args->step,$args->product,$args->script,$args->comment);
  $ret->user_feedback = sprintf('已知缺陷编辑成功', $args->testcase);

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
  $gui->main_descr = 'm已知缺陷m' . TITLE_SEP . $args->testcase;

  $gui->submit_button_label = lang_get('btn_save');
  $gui->submit_button_action = 'do_update';
  $gui->action_descr = '删除已知缺陷';

  $ret = new stdClass();
  $ret->template = 'issueView.tpl';
  $ret->status = $platform_mgr->deleteIssue($args->issue_id,true);
  $ret->user_feedback = sprintf('删除成功', $args->name);

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
  $gui->user_feedback = array('type' => 'INFO', 'message' => '');
  $gui->issue_id = $args->issue_id;
  $gui->testcase = $args->testcase;
  $gui->step = $args->step;
  $gui->product = $args->product;
  $gui->script = $args->script;
  $gui->comment = $args->comment;
    
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
