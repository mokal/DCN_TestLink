<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-language" content="en" />
	<meta http-equiv="expires" content="-1" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="author" content="guomf" />
	<meta name="copyright" content="GNU" />
	<meta name="robots" content="NOFOLLOW" />
	<title>TestLink</title>
</head>
<body>
<?php
require('../third_party/PHPExcel/PHPExcel.php');

$time_start = $_POST['time_start'];
$time_stop = $_POST['time_stop'];
$tplan_name = $_POST['tplanname'];

$alldata = getMonthReport(3,$time_start,$time_stop,$tplan_name);

if( $alldata == 0 ) {
    echo "</br><p align='center'>该时间段内没有执行记录，请重新选择时间段!</p>" ;
    echo "</br><p align='center'><a href='index.php'>BACK</a></p>";
}else{
ob_clean();
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator('DCN TestLink')
                             ->setLastModifiedBy('DCN TestLink')
			->setTitle('DCN Weekly Report');
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(TRUE);

$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet();

$objActSheet->mergeCells('A1:K1');
$objActSheet->setCellValue('A1', 'DCN测试中心确认测试执行情况:'.$time_start.'至'.$time_stop);

$objActSheet->getStyle('A1')->getFont()->setBold(TRUE);
$objActSheet->getStyle('A2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('B2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('C2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('D2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('E2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('F2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('G2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('H2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('I2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('J2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('K2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('L2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('M2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('N2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('O2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('P2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('Q2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('R2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('S2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('T2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('U2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('V2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('W2')->getFont()->setBold(TRUE);
$objActSheet->getStyle('X2')->getFont()->setBold(TRUE);

$objActSheet->setCellValue('A2', 'JobID');
$objActSheet->setCellValue('B2', 'Notes');
$objActSheet->setCellValue('C2', '测试计划');  
$objActSheet->setCellValue('D2', '测试设备');
$objActSheet->setCellValue('E2', '测试版本');
$objActSheet->setCellValue('F2', '版本结论');
$objActSheet->setCellValue('G2', '模块');
$objActSheet->setCellValue('H2', '拓扑类型');  
$objActSheet->setCellValue('I2', '测试人员');
$objActSheet->setCellValue('J2', '测试时间');
$objActSheet->setCellValue('K2', '总用例');
$objActSheet->setCellValue('L2', '已执行');
$objActSheet->setCellValue('M2', 'Fail');
$objActSheet->setCellValue('N2', '失败率%');
$objActSheet->setCellValue('O2', '交换机Bug');
$objActSheet->setCellValue('P2', '已知缺陷');
$objActSheet->setCellValue('Q2', '脚本问题');
$objActSheet->setCellValue('R2', '产品差异');
$objActSheet->setCellValue('S2', '版本差异');
$objActSheet->setCellValue('T2', '方案问题');
$objActSheet->setCellValue('U2', '环境问题');
$objActSheet->setCellValue('V2', '无效测试');
$objActSheet->setCellValue('W2', '未分析');
$objActSheet->setCellValue('X2', '未分析率');

$objActSheet->getColumnDimension('A')->setWidth(22);
$objActSheet->getColumnDimension('B')->setWidth(40);
$objActSheet->getColumnDimension('C')->setWidth(40);
$objActSheet->getColumnDimension('D')->setWidth(40);
$objActSheet->getColumnDimension('E')->setWidth(35);
$objActSheet->getColumnDimension('G')->setWidth(15);
$objActSheet->getColumnDimension('I')->setWidth(20);
$objActSheet->getColumnDimension('J')->setWidth(20);

$caseindex = 3;
foreach($alldata as $resultdetail){
	$objActSheet->setCellValue('A'.$caseindex, $resultdetail['job_id']);
	if( $resultdetail['user'] != 'DCN' ){
		$objActSheet->getCell('A'.$caseindex)->getHyperlink()->setUrl('http://10.1.145.70/lib/results/dcnReport.php?format=0&tplan_id='.$resultdetail['tplan_id'].'&device_id='.$resultdetail['device_id'].'&topo_type=0&build_id='.$resultdetail['build_id']);
		$objActSheet->getCell('A'.$caseindex)->getHyperlink()->getTooltip('查阅在线报告');
	}
	$objActSheet->setCellValue('B'.$caseindex, $resultdetail['endwhy']);
	$objActSheet->setCellValue('C'.$caseindex, $resultdetail['testplan']);
	$objActSheet->setCellValue('D'.$caseindex, $resultdetail['device']);
	$objActSheet->setCellValue('E'.$caseindex, $resultdetail['build']);
	$objActSheet->setCellValue('F'.$caseindex, $resultdetail['buildresult']);
	$objActSheet->setCellValue('G'.$caseindex, $resultdetail['job_type']);
	$objActSheet->setCellValue('H'.$caseindex, $resultdetail['topo_type']);  
	$objActSheet->setCellValue('I'.$caseindex, $resultdetail['user']);
	$objActSheet->setCellValue('J'.$caseindex, $resultdetail['job_startTime']);
	$objActSheet->setCellValue('K'.$caseindex, $resultdetail['total']);
	$objActSheet->setCellValue('L'.$caseindex, $resultdetail['runend']);
	$objActSheet->setCellValue('M'.$caseindex, $resultdetail['fail']);
	$objActSheet->setCellValue('N'.$caseindex, $resultdetail['fail']*100/($resultdetail['runend']+0.01));  #x*100/(y+0.01)
	$objActSheet->setCellValue('O'.$caseindex, $resultdetail['switch']);
	$objActSheet->setCellValue('P'.$caseindex, $resultdetail['accept']);
	$objActSheet->setCellValue('Q'.$caseindex, $resultdetail['script']);
	$objActSheet->setCellValue('R'.$caseindex, $resultdetail['productdiff']);
	$objActSheet->setCellValue('S'.$caseindex, $resultdetail['versiondiff']);
	$objActSheet->setCellValue('T'.$caseindex, $resultdetail['checklist']);
	$objActSheet->setCellValue('U'.$caseindex, $resultdetail['environment']);
	$objActSheet->setCellValue('V'.$caseindex, $resultdetail['na']);
	$objActSheet->setCellValue('W'.$caseindex, $resultdetail['none']);
	$objActSheet->setCellValue('X'.$caseindex, $resultdetail['none']*100/($resultdetail['fail']+0.01));
    ++$caseindex;
}

//设置居中
$objActSheet->getStyle('A2:X'.$caseindex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//画出sheet的边框线条
$styleArray = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
$caseindex =  $caseindex - 1;
$objActSheet->getStyle('A1:X'.$caseindex)->applyFromArray($styleArray);

//设置自动筛选
$objActSheet->setAutoFilter('A2:X2');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-Disposition: attachment;filename="DCN Weekly affirm Report.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

}

function getMonthReport($tproject_id,$start,$end,$tplanname)
{
	$filter = '';
	if($tproject_id == 1 ){
		$filter = " AND J.job_type IN ('affirm2','affirm3','affirm3|affirm2') ";
	}elseif($tproject_id == 2){
		$filter = " AND J.job_type IN ('waffirm','waffirm_X86') " ;
	}else{
		$filter = " AND J.job_type IN ('affirm2','affirm3','affirm3|affirm2','waffirm','waffirm_X86') ";
	}
	if( $tplanname != null ){
		$filter = $filter . " AND TP.name LIKE '%{$tplanname}%' ";
	}
	
	$db = mysqli_connect('192.168.50.192', 'testlink', 'Eqp9qH9Pya9FMVyV', 'testlink') or die("Connect failed". mysql_error());
	if(!$db){
		printf("Can't connect to mysql 192.168.50.192, Error code is: %s", mysqli_error());
		exit;
	}
	
	mysqli_query($db, "SET NAMES 'utf8'");	
	$sql = "SELECT J.*, U.login as user, D.name as device,BU.name as build,TP.name as testplan,BU.result as buildresult " .
			" FROM run_end_jobs as J, users as U, platforms as D , nodes_hierarchy as TP, builds as BU" .
			" WHERE J.job_endTime >= '{$start}' AND J.job_endTime <= '{$end}' AND U.id = J.user_id AND J.device_id=D.id {$filter} AND BU.id=J.build_id AND TP.id=J.tplan_id ORDER BY J.job_startTime DESC";
	$result = mysqli_query($db,$sql);
	$num = mysqli_num_rows($result);
	
	$returnrs = array() ;
	if( $num != 0 ){
		$returnrs['total']['user'] = 'DCN';
		$returnrs['total']['endwhy'] = '';
		$returnrs['total']['job_startTime'] = '';
		$returnrs['total']['job_type'] = '确认测试' ;
		$returnrs['total']['device'] = $num . "设备(次)" ;

		$returnrs['total']['job_id'] = '' ;
		$returnrs['total']['topo_type'] = '' ;
		$returnrs['total']['testplan'] = '测试执行汇总' ;
		$returnrs['total']['build'] = '' ;
		$returnrs['total']['buildresult'] = '' ;
		$returnrs['total']['total']=$returnrs['total']['runend']=$returnrs['total']['fail']= $returnrs['total']['switch'] =$returnrs['total']['accept']=$returnrs['total']['script']=$returnrs['total']['productdiff']=$returnrs['total']['versiondiff']=$returnrs['total']['checklist']=$returnrs['total']['environment']=$returnrs['total']['na']=0;
		for( $i = 0; $i < $num; $i++ ){
			$job = mysqli_fetch_assoc($result);
			$temp['user'] = $job['user'] ;
			$temp['job_id'] = $job['job_id'] ;
			if($job['topo_type'] == 0){ $temp['topo_type'] = '一般独立';}
			elseif($job['topo_type'] == 1){ $temp['topo_type'] = '一般堆叠';}
			elseif($job['topo_type'] == 2){ $temp['topo_type'] = '独立跨板卡';}
			elseif($job['topo_type'] == 3){ $temp['topo_type'] = '堆叠跨机架';}
			else{ $temp['topo_type'] = $job['topo_type'];}
			
			$temp['endwhy'] = $job['endwhy'] ;
			$temp['topo_type'] = $job['topo_type'] ;
			$temp['job_startTime'] = $job['job_startTime'] ;
			$temp['job_type'] = $job['job_type'] ;
			$temp['device'] = $job['device'] ;
			$temp['testplan'] = $job['testplan'] ;
			$temp['build'] = $job['build'] ;
			$temp['device_id'] = $job['device_id'] ;
			$temp['tplan_id'] = $job['tplan_id'] ;
			$temp['build_id'] = $job['build_id'] ;
			$temp['total'] = $job['total_case'] ;
			$temp['buildresult'] = '';
			if($job['buildresult'] == 'pass'){
				$temp['buildresult'] = '通过';
			}elseif($job['buildresult'] == 'fail'){
				$temp['buildresult'] = '不通过';
			}elseif($job['buildresult'] == 'verify'){
				$temp['buildresult'] = '验证后通过';
			}
			$temp['fail'] = $job['fail_case'] + $job['na_case'] + $job['accept_case'] + $job['block_case'] + $job['warn_case'] + $job['skip_case'] ;
			$temp['runend'] = $job['runend_case'] ;
			$returnrs['total']['total'] += $temp['total'] ;
			$returnrs['total']['fail'] += $temp['fail'] ;
			$returnrs['total']['runend'] += $temp['runend'] ;

			$jobid = $job['job_id'] ;
			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'f' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['switch'] = $rs['total'];
			$returnrs['total']['switch'] += $temp['switch'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'a' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['accept'] = $rs['total'];
			$returnrs['total']['accept'] += $temp['accept'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 's' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['script'] = $rs['total'];
			$returnrs['total']['script'] += $temp['script'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'p' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['productdiff'] = $rs['total'];
			$returnrs['total']['productdiff'] += $temp['productdiff'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'v' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['versiondiff'] = $rs['total'];
			$returnrs['total']['versiondiff'] += $temp['versiondiff'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'c' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['checklist'] = $rs['total'];
			$returnrs['total']['checklist'] += $temp['checklist'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'e' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['environment'] = $rs['total'];
			$returnrs['total']['environment'] += $temp['environment'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'x' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['na'] = $rs['total'];
			$returnrs['total']['na'] += $temp['na'] ;

			$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'none' AND result != 'p' ";
			$rs = mysqli_query($db,$sql);
			$rs = mysqli_fetch_assoc($rs);
			$temp['none'] = $rs['total'];
			$returnrs['total']['none'] += $temp['none'] ;
					
			$returnrs[] = $temp ;
		}
	}else{
		mysqli_free_result($result);
		mysqli_close($db);
		return 0;
	}
	mysqli_free_result($result);
	mysqli_close($db);
	return $returnrs ;
}
	
?>
</body>
</html>