<?php
require('../../config.inc.php');
require_once('common.php');
require('../../third_party/PHPExcel/PHPExcel.php');

$args = init_args($db);

$tplan_mgr = new testplan($db);
$allsuite = $tplan_mgr->get_all_suites();
$platformSet = $tplan_mgr->getPlatforms($args->tplan_id,array('outputFormat' => 'map'));
$testplan = $tplan_mgr->get_by_id($args->tplan_id);
if ($args->build_id == 1){
    $testbuild = array('name'=>'任意版本','notes'=>'');
}else{
    $testbuild = $tplan_mgr->get_build_by_id($args->tplan_id,$args->build_id);
}
if($args->device_id == '1'){
    $alldevice = $platformSet;
	foreach($alldevice as $device_id=>$device_name){
		$results[$device_id] = $tplan_mgr->get_exec_device_group_by_suite($args->tplan_id,$args->build_id,$device_id,$args->stack);
	}
}else{
	$alldevice = array($args->device_id=>$platformSet[$args->device_id]);
	$results[$args->device_id] = $tplan_mgr->get_exec_device_group_by_suite($args->tplan_id,$args->build_id,$args->device_id,$args->stack);
}

ob_clean();
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator('DCN TestLink')
                             ->setLastModifiedBy('DCN TestLink')
							 ->setTitle('DCN Test Report');
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(TRUE);

$allindex = 0;
$deviceindex = 0;

foreach($alldevice as $deviceid=>$devicename){

if($allindex != 0){
	$objWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $deviceid.'_Summary');
	$objPHPExcel->addSheet($objWorkSheet);
	$objPHPExcel->setActiveSheetIndex($allindex);
	$objActSheet = $objPHPExcel->getActiveSheet();
}		
//第一个sheet写入全局的统计信息
$objPHPExcel->setActiveSheetIndex($allindex);
$objActSheet = $objPHPExcel->getActiveSheet();

//office的sheet名最长允许31个字符，如果设备名称偏长，就将设备名中的无用段删掉
$name = $devicename;
if( strlen($name) > 23){
    $devicename_array = explode('-' , $name );    
    foreach($devicename_array as $index=>$substr){
        if( preg_match("/^(DCS|DCRS|R|POE|DC|L|SI|EI|TSC|C|Bigstone)$/i" , $substr) ){    unset($devicename_array[$index]);  }
    }
    $name = implode('-' , $devicename_array ); 
    if( strlen($name) > 23){   $name = (string)$deviceid ; }
}

$objActSheet->setTitle($name.'_Summary');
$objActSheet->getColumnDimension('A')->setWidth(15);
$objActSheet->getStyle('A1:A4')->getFont()->setBold(TRUE);
$objActSheet->setCellValue('A1', '测试计划');
$objActSheet->setCellValue('A2', '测试设备');
$objActSheet->setCellValue('A3', '测试版本');
$objActSheet->setCellValue('A4', '版本详情');
$objActSheet->mergeCells('B1:J1');
$objActSheet->mergeCells('B2:J2');
$objActSheet->mergeCells('B3:J3');
$objActSheet->mergeCells('B4:J4');
$objActSheet->setCellValue('B1', $testplan['name']);
$objActSheet->setCellValue('B2', $devicename);
$objActSheet->getRowDimension(4)->setRowHeight(150);
$objActSheet->setCellValue('B3', $testbuild['name']);
$objActSheet->setCellValue('B4', $testbuild['notes']);

$index = 5;
$objActSheet->getStyle('A5:J5')->getFont()->setBold(TRUE);

$objActSheet->setCellValue('A'.$index, 'Module');
$objActSheet->setCellValue('B'.$index, 'Total');  
$objActSheet->setCellValue('C'.$index, 'PASS'); 
$objActSheet->setCellValue('D'.$index, 'Failed'); 
$objActSheet->setCellValue('E'.$index, 'Accept');
$objActSheet->setCellValue('F'.$index, 'Block');
$objActSheet->setCellValue('G'.$index, 'Skip');  
$objActSheet->setCellValue('H'.$index, 'Warn'); 
$objActSheet->setCellValue('I'.$index, 'N/A'); 
$objActSheet->setCellValue('J'.$index, 'No Run');

++$index;
$objActSheet->setCellValue('A'.$index, '所有模块');
$objActSheet->setCellValue('B'.$index, $results[$deviceid][0]['total']);  
$objActSheet->setCellValue('C'.$index, $results[$deviceid][0]['pass']); 
$objActSheet->setCellValue('D'.$index, $results[$deviceid][0]['fail']); 
$objActSheet->setCellValue('E'.$index, $results[$deviceid][0]['accept']);
$objActSheet->setCellValue('F'.$index, $results[$deviceid][0]['block']);
$objActSheet->setCellValue('G'.$index, $results[$deviceid][0]['skip']);  
$objActSheet->setCellValue('H'.$index, $results[$deviceid][0]['warn']); 
$objActSheet->setCellValue('I'.$index, $results[$deviceid][0]['na']); 
$objActSheet->setCellValue('J'.$index, $results[$deviceid][0]['norun']);

//遍历，按模块写入该设备的统计信息
++$index;
$tempallindex = $allindex;
foreach($results[$deviceid] as $suiteid=>$result){
	if($suiteid != 0){
		$objPHPExcel->setActiveSheetIndex($tempallindex);
		$objActSheet = $objPHPExcel->getActiveSheet();
		$objActSheet->setCellValue('A'.$index, $allsuite[$suiteid]);
		$objActSheet->setCellValue('B'.$index, $result['total']);  
		$objActSheet->setCellValue('C'.$index, $result['pass']); 
		$objActSheet->setCellValue('D'.$index, $result['fail']); 
		$objActSheet->setCellValue('E'.$index, $result['accept']);
		$objActSheet->setCellValue('F'.$index, $result['block']);
		$objActSheet->setCellValue('G'.$index, $result['skip']);  
		$objActSheet->setCellValue('H'.$index, $result['warn']); 
		$objActSheet->setCellValue('I'.$index, $result['na']); 
		$objActSheet->setCellValue('J'.$index, $result['norun']);
		++$index;
		//针对每一个模块的详细结果，写入到excel的不同sheet中
		$objWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $name.'_'.$allsuite[$suiteid]);
		$objPHPExcel->addSheet($objWorkSheet);
		$tempallindex = $allindex;
		++$allindex;
		$objPHPExcel->setActiveSheetIndex($allindex);
		$objActSheet = $objPHPExcel->getActiveSheet();	
		
		$objActSheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		$objActSheet->getStyle('A1:H1')->getFont()->setBold(TRUE);
		
	    $objActSheet->setCellValue('A1', 'Case Number');
	    $objActSheet->setCellValue('B1', 'Test Cases');  
	    $objActSheet->setCellValue('C1', 'Priority'); 
	    $objActSheet->setCellValue('D1', 'Version'); 
	    $objActSheet->setCellValue('E1', 'Result');
		$objActSheet->setCellValue('F1', 'Time');
		$objActSheet->setCellValue('G1', 'User');
	    $objActSheet->setCellValue('H1', 'Remark'); 
		$objActSheet->getColumnDimension('A')->setWidth(15);
	    $objActSheet->getColumnDimension('B')->setWidth(80);
	    $objActSheet->getColumnDimension('F')->setWidth(20);
	    $objActSheet->getColumnDimension('H')->setWidth(40);
		
		$caseindex = 2;
		foreach($result['cases'] as $resultdetail){
			$objActSheet->setCellValue('A'.$caseindex, $resultdetail['tc_name']);
			$objActSheet->setCellValue('B'.$caseindex, $resultdetail['summary']);  
			$objActSheet->setCellValue('C'.$caseindex, ''); 
			$objActSheet->setCellValue('D'.$caseindex, ''); 
			$objActSheet->setCellValue('E'.$caseindex, $resultdetail['status']);
			$objActSheet->setCellValue('F'.$caseindex, $resultdetail['time']);
			$objActSheet->setCellValue('G'.$caseindex, $resultdetail['user']);
			$objActSheet->setCellValue('H'.$caseindex, $resultdetail['notes']);
            ++$caseindex;
        }
		//画出每个模块结果详细sheet的边框线条
		$styleArray = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
		$caseindex =  $caseindex - 1;
		$objActSheet->getStyle('A1:H'.$caseindex)->applyFromArray($styleArray);
    }
}

++$deviceindex;
++$allindex;
}
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-Disposition: attachment;filename="Test Report.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

function init_args(&$dbHandler)
{
  $iParams = array("apikey" => array(tlInputParameter::STRING_N,32,64),
                   "tproject_id" => array(tlInputParameter::INT_N), 
	               "tplan_id" => array(tlInputParameter::INT_N),
                   "build_id" => array(tlInputParameter::INT_N),
                   "device_id" => array(tlInputParameter::INT_N),
                  "stack" => array(tlInputParameter::INT_N),
		           "format" => array(tlInputParameter::INT_N));

	$args = new stdClass();
	$pParams = R_PARAMS($iParams,$args);
  if( !is_null($args->apikey) ){
    $cerbero = new stdClass();
    $cerbero->args = new stdClass();
    $cerbero->args->tproject_id = $args->tproject_id;
    $cerbero->args->tplan_id = $args->tplan_id;
	
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