<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$gui->vars = $platform_mgr->getAllVars();
$total_vars = count($gui->vars);
$gui->suites = $platform_mgr->getAllSuites();
$gui->current_var = 0 ;
$gui->current_suite = 0 ;

if ( isset($_GET['suite_id']) ){
	$gui->current_suite = $_GET['suite_id'] ;
	if ( isset($_GET['add_var_name']) ){
		$addresult = $platform_mgr->addNewVar($_GET['suite_id'],$_GET['add_var_name']);
		if($addresult == 0){
			echo "<script>alert('分支名称已经存在,请检查!');</script>";			
		}
	}
}

if ( isset($_GET['var_id']) ){
	if ( isset($_GET['deletecase']) ){
		$platform_mgr->deleteVarTcversion($_GET['var_id'],$_GET['deletecase']);
	}
	
	if ( isset($_GET['add_case_script']) ){
		$result = $platform_mgr->addVarTcversion($_GET['var_id'],$_GET['add_case_script'],$args->login_username);
		echo "<script>alert('{$result}');</script>";
	}
	
    $gui->var_tcversion = $platform_mgr->getVarTcversions($_GET['suite_id'],$_GET['var_id']);
    $gui->current_var = $_GET['var_id'] ;
    if( isset($_GET['exportvar']) ){
    	$index = rand(1,10);
    	if($_GET['suite_id']==3959){//affirm2
    		$filename = "../../upload_area/exec_logs/var_export/affirm2_var{$index}.tcl";
    		$file = fopen($filename,'w');
    		$text = "# This affirm2 var file created by TestLink!\r\n";
    		fwrite($file,$text);
    		foreach($gui->var_tcversion['var'] as $id=>$tcversion){
    			if ( preg_match("/^(.*?)\.py/i" ,$tcversion['name'], $m)==false ){
    				preg_match("/^(.*?)\.tcl/i" ,$tcversion['name'], $m); 			
    			}
    			$text = 'set {' . $m[1] . '} 1' . "\r\n";
    			fwrite($file,$text);
    		}
    		$text = '#below cases is not include in this var' . "\r\n";
    		fwrite($file,$text);
    		foreach($gui->var_tcversion['not_in_id'] as $id){
    			$text = '#set {' . $gui->var_tcversion['all'][$id]['name'] . '} 1' . "\r\n";
    			fwrite($file,$text);
    		}
    		fclose($file);
    		echo "<script>window.open('{$filename}');</script>";
    	}elseif($_GET['suite_id']==4944){//affirm3
    		$filename = "../../upload_area/exec_logs/var_export/affirm3_var{$index}.prj";
    		$file = fopen($filename,'w');
    		
    		$text = '{"customvarlist": [], "sutaddresslist": {}, "projectname": "Testlink_Created", "filelist": ' .
      		        '[["affirm_initial.py --RunLevel 1", "affirm_uninitial.py --RunLevel 100"';
    		fwrite($file,$text);
    		   		
    		foreach($gui->var_tcversion['var'] as $tcversion){
    			$name = $tcversion['name'];
    			$text = ', "' . "{$name}" . '  --RunLevel 10"';
    			fwrite($file,$text);
    		}
    		$text = '], []], "topovarlist": [], "ixiavarlist": []}';
    		fwrite($file,$text);
    		
    		fclose($file);
    		echo "<script>window.open('{$filename}');</script>";
    		
    	}elseif($_GET['suite_id']==666){//function
    		
    	}
    	
    }
}

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->assign('vars', json_encode($gui->vars) );
$smarty->assign('total_vars', $total_vars );
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 
	$args->login_username = $_SESSION['currentUser']->getDisplayName();
	return $args;
}

function checkRights(&$db,&$user)
{
	return True;
}
?>