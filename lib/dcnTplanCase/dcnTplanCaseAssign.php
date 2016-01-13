<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();


$tplan_id = $_GET['tplan_id'];
$device_id = $_GET['device_id'];
$tplan_name = $_GET['tplanname'];
$user_name = $_GET['username'];
$divindex =  $_GET['divindex'];
//var_cases
$fp = @fopen($_FILES['varfile']['tmp_name'] , "r") ;

if( preg_match("/^.*?\.tcl/i" , $_FILES['varfile']['name'] , $temp) ){
   $suite = '确认测试2.0' ;
   if ( $fp ){
      $var_cases = array();
      while ( !feof($fp) ){
         $buffer = fgets($fp , 4096) ;
         if ( preg_match("/^set {affirm_(.*?)} 1/i" ,$buffer, $case) ) { 
             $var_cases[] = $case[1] ;
         }elseif( preg_match("/^set {(bf.*?)} 1/i" ,$buffer, $case) ) { 
             $var_cases[] = $case[1] ;
         }elseif( preg_match("/^set {(mt.*?)} 1/i" ,$buffer, $case) ) { 
             $var_cases[] = $case[1] ;
         }
      }
   }else{   
      echo "<script>alert('Read File Error！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
   if( count($var_cases) == 0 ){ 
      echo "<script>alert('文件中没有找到测试例定义数据，请检查！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
}elseif( preg_match("/^.*?\.prj/i" , $_FILES['varfile']['name'] , $temp) ){
   $suite = '确认测试3.0' ;
   if ( $fp ){
      $var_cases = array();
      while ( !feof($fp) ){
         $buffer = fgets($fp , 4096) ;
          if ( preg_match_all('/affirm_[\d\.]*\.py/' ,$buffer, $case,1) ) { 
               foreach( $case[0] as $testcase){     
                    $testcase = str_replace('.py', '' ,$testcase) ; 
                    $testcase = str_replace('affirm_', '' ,$testcase) ; 
                    $var_cases[] = $testcase ;    
               }
           }
      }
   }else{   
      echo "<script>alert('Read File Error！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
   if( count($var_cases) == 0 ){ 
      echo "<script>alert('文件中没有找到测试例定义数据，请检查！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
}elseif( preg_match("/^.*?\.testlink/i" , $_FILES['varfile']['name'] , $temp) ){
   $suite = 'testlink' ;
   if ( $fp ){
      $var_cases = array();
      while ( !feof($fp) ){
         $buffer = fgets($fp , 4096) ;
         if ( preg_match("/^#(.*?)#/i" ,$buffer, $case) ) {
         	$testcase = str_replace("\\", "\\\\" ,$case[1]) ;
         	$testcase = str_replace(' ', '\\ ' ,$testcase) ;
            $var_cases[] = $testcase ;
         }
      }
   }else{
      echo "<script>alert('Read File Error！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
   if( count($var_cases) == 0 ){ 
      echo "<script>alert('文件中没有找到测试例定义数据，请检查！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>"; 
      exit();
   }
}else{
    echo "<script>alert('别逗，你上传的不是确认2.0 var文件或确认3.0 prj文件或导出的.testlink文件！');self.location.href='/lib/dcnTplanCase/tplanCaseView.php?id={$tplan_id}&name={$tplan_name}&divindex={$divindex}' ;</script>";
    exit();
}

//testlink_cases
$platform_mgr = new tlPlatform($db, $args->testproject_id);
$tcase_mgr = new testcase ($db);

if($suite == 'testlink'){
	$testlink_cases = $platform_mgr->getTplanDeviceCaseScript($tplan_id,$device_id);
}else{
	$testlink_cases = $platform_mgr->getTplanDeviceCases($tplan_id,$device_id,$suite);
}

$gui = new stdClass();

$gui->needadd = array_diff($var_cases,$testlink_cases[0]);
$needdelete = array_diff($testlink_cases[0],$var_cases);
$gui->candelete = array_diff($testlink_cases[1],$var_cases);
$gui->cannotdelete = array_diff($needdelete,$gui->candelete);

$gui->added = $gui->deleted = array() ;

if( !is_null($gui->needadd) ){
    foreach($gui->needadd as $case){
        $rs = $tcase_mgr->modifyTplanDeviceCases($tplan_id, $device_id, $suite ,$case, "add", $user_name);
        if( $rs == 'Success' ){
             $gui->added[] = $case ; 
        }
    }
}

if( !is_null($gui->candelete) ){
    foreach($gui->candelete as $case){
        $rs = $tcase_mgr->modifyTplanDeviceCases($tplan_id, $device_id, $suite ,$case, "delete",$user_name);
        if( $rs == 'Success' ){
             $gui->deleted[] = $case ; 
        }
    }
}

if( !is_null($gui->cannotdelete) ){
	foreach($gui->cannotdelete as $case){
		$rs = $tcase_mgr->modifyTplanDeviceCases($tplan_id, $device_id, $suite ,$case, "deactive", $user_name);
		if( $rs == 'Success' ){
			$gui->deactived[] = $case ;
		}
	}
}

$smarty = new TLSmarty();
$smarty->assign('gui',$gui);
$smarty->display($templateCfg->template_dir . $templateCfg->default_template);

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 

	return $args;
}

function checkRights(&$db,&$user)
{
	return True;
}

?>

