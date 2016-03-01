<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);

$gui = new stdClass();
$job_type = $_POST['module'];

$platform = 'all';
if ( $job_type == 'affirm2'){
	$suite = "确认测试2.0";
	$platform = $_POST['affirm2platform'];
}
if ( $job_type == 'affirm3'){
	$suite = "确认测试3.0";
    if( isset($_POST['affirm3and2check']) ){
       $job_type = $suite = "affirm3|affirm2";
    }
}

if ( $job_type == 'cmdauto'){
	$suite = "CommandLine";
}

if ( $job_type == 'memorytest'){
	$suite = "MemoryCrash";
}

if ( $job_type == 'dianxing'){
	$job_type = $suite = $_POST['dianxingEnvSel'];
}

if ( $job_type == 'softperformance'){
    switch($_POST['performanceSel']){
    	case '1':
    		$job_type = 'IGMPSnp性能';
    		$suite='IgmpSnooping处理性能';
    		break;
    	case '2':
    		$job_type = 'IGMPSnp时延';
    		$suite='IgmpSnooping时延';
    		break;
    	case '3':
    		$job_type = '协议收包缓冲';
    		$suite='协议收包缓冲区长度';
    		break;
    	case '4':
    		$job_type = '板间协议处理';
    		$suite='板间协议处理能力';
    		break;
    	default:
    		$job_type = 'softperformance';
    		$suite='软件性能测试';
    		break;
    }
}

$job_is_running = $platform_mgr->getJobExist($args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $job_type);
if($job_type == 'function'){
	$total_case = 1; // get this number in later code
}else{
	$total_case =  $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,$suite,$platform);
}
if($job_is_running){
  echo "<script> {window.alert('该版本上此模块测试任务已经在执行中，请检查');location.href='/lib/dcnJobs/jobsView.php?div=now'} </script>";
}
elseif($total_case == 0){
  echo "<script> {window.alert('该版本上此模块没有制定覆盖策略(模块测试例为0)，请检查');location.href='/lib/dcnJobs/jobsView.php?div=now'} </script>";
}
else{
  //生成一个jobid：user+时间戳
    $jobid = (string)$args->user_name . (string)time();
    $client_ip = getIP();
    $job_type = $_POST['module'];
    if($job_type == 'affirm2'){
       $suite='确认测试2.0';
       $s1ip = $_POST['affirm2s1ip']; 
       $s2ip = $_POST['affirm2s2ip']; 
       $s2device = $_POST['affirm2s2device']; 
       $s1sn = $_POST['affirm2s1sn']; 
       $s2sn = $_POST['affirm2s2sn']; 
       $s1p1 = $_POST['affirm2s1p1']; 
       $s1p2 = $_POST['affirm2s1p2'];
       $s1p3 = $_POST['affirm2s1p3']; 
       $s2p1 = $_POST['affirm2s2p1']; 
       $s2p2 = $_POST['affirm2s2p2']; 
       $s2p3 = $_POST['affirm2s2p3']; 
       $ixia_ip = $_POST['affirm2ixiaip']; 
       $tp1 = $_POST['affirm2tp1']; 
       $tp2 = $_POST['affirm2tp2']; 
       $productversion = $_POST['productversion']; 
       $scriptversion= $_POST['scriptversion'];

       $platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
       $platform_mgr->addAffirm2Run($jobid, $platform, $s1ip, $s2ip, $s2device, $s1sn, $s2sn, $s1p1, $s1p2, $s1p3, $s2p1, $s2p2, $s2p3, $ixia_ip, $tp1, $tp2,$productversion,$scriptversion);
       
       echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    }elseif( $job_type == 'affirm3' ){
       $suite='确认测试3.0';
       $s1ip = $_POST['affirm3s1ip']; 
       $s4ip = $_POST['affirm3s4ip']; 
       $s1device = $_POST['affirm3s1device'];
       $s1p1 = $_POST['affirm3s1p1']; 
       $s1p2 = $_POST['affirm3s1p2']; 
       $s1p3 = $_POST['affirm3s1p3']; 
       $s1p4 = $_POST['affirm3s1p4']; 
       $s1p5 = $_POST['affirm3s1p5']; 
       $s1p6 = $_POST['affirm3s1p6']; 
       $s1p7 = $_POST['affirm3s1p7'];
       
       $s2ip = $_POST['affirm3s2ip']; 
       $s5ip = $_POST['affirm3s5ip']; 
       $s2p1 = $_POST['affirm3s2p1']; 
       $s2p2 = $_POST['affirm3s2p2']; 
       $s2p3 = $_POST['affirm3s2p3']; 
       $s2p4 = $_POST['affirm3s2p4']; 
       $s2p5 = $_POST['affirm3s2p5']; 
       $s2p6 = $_POST['affirm3s2p6']; 
       $s2p7 = $_POST['affirm3s2p7']; 
       $s2p8 = $_POST['affirm3s2p8']; 
       $s2p9 = $_POST['affirm3s2p9']; 
       $s2p10 = $_POST['affirm3s2p10']; 
       $s2p11 = $_POST['affirm3s2p11']; 
       $s2p12 = $_POST['affirm3s2p12']; 
       $s2device = $_POST['affirm3s2device']; 

       $s6ip = $_POST['affirm3s6ip']; 
       $s6p1 = $_POST['affirm3s6p1']; 
       $s6p2 = $_POST['affirm3s6p2']; 

       $ixia_ip = $_POST['affirm3ixiaip']; 
       $tp1 = $_POST['affirm3tp1']; 
       $tp2 = $_POST['affirm3tp2']; 

       $server = $_POST['affirm3server']; 
       $client = $_POST['affirm3client']; 
       $admin_ip = $_POST['affirm3admin_ip']; 
       $radius = $_POST['affirm3radius']; 

       if( isset($_POST['affirm3and2check']) ){
            $job_type  =  "affirm3|affirm2";
            $suite='affirm3|affirm2';
       }

      $platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
      $platform_mgr->addAffirm3Run($jobid, $s1ip, $s4ip, $s1p1, $s1p2, $s1p3, $s1p4, $s1p5, $s1p6, $s1p7, $s1device, $s2ip, $s5ip, $s2p1, $s2p2, $s2p3, $s2p4, $s2p5, $s2p6, $s2p7, $s2p8, $s2p9, $s2p10, $s2p11, $s2p12, $s2device, $ixia_ip, $tp1, $tp2, $s6ip, $s6p1, $s6p2, $server, $client, $admin_ip, $radius);
      
      echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    }elseif( $job_type == 'dianxing' ){
    	if($_POST['dianxingEnvSel']=='college'){
    		$job_type = 'college';
    		$suite='college';
    		$ixia = $_POST['collegeixia'];
    		$tp1 = $_POST['collegetp1'];
    		$tp2 = $_POST['collegetp2'];
    		$tp3 = $_POST['collegetp3'];
    		
    		$s1ip = $_POST['colleges1ip'];
    		$s1p1 = $_POST['colleges1p1'];
    		$s1p2 = $_POST['colleges1p2'];
    		$s1p3 = $_POST['colleges1p3'];
    		$s1p4 = $_POST['colleges1p4'];
    		$s1p5 = $_POST['colleges1p5'];
    		$s1p6 = $_POST['colleges1p6'];
    		
    		$s2ip = $_POST['colleges2ip'];
    		$s2p1 = $_POST['colleges2p1'];
    		$s2p2 = $_POST['colleges2p2'];
    		$s2p3 = $_POST['colleges2p3'];
    		$s2p4 = $_POST['colleges2p4'];
    		$s2p5 = $_POST['colleges2p5'];
   		
    		$s3ip = $_POST['colleges3ip'];
    		$s3p1 = $_POST['colleges3p1'];
    		$s3p2 = $_POST['colleges3p2'];
    		$s3p3 = $_POST['colleges3p3'];
    		
    		$s4ip = $_POST['colleges4ip'];
    		$s4p1 = $_POST['colleges4p1'];
    		$s4p2 = $_POST['colleges4p2'];
    		$s4p3 = $_POST['colleges4p3'];
    		
    		$s5ip = $_POST['colleges5ip'];
    		$s5p1 = $_POST['colleges5p1'];
    		$s5p2 = $_POST['colleges5p2'];
    		$s5p5 = $_POST['colleges5p5'];
    		$s5p6 = $_POST['colleges5p6'];
    		$s5p7 = $_POST['colleges5p7'];
    		$s5p8 = $_POST['colleges5p8'];
    		$s5p9 = $_POST['colleges5p9'];
    		$s5p10 = $_POST['colleges5p10'];
    		$s5p11 = $_POST['colleges5p11'];
    		$s5p12 = $_POST['colleges5p12'];
    		$s5p13 = $_POST['colleges5p13'];
    		$s5p14 = $_POST['colleges5p14'];
    		$s5p5to14 = $_POST['colleges5p514'];
    		$s5p15 = $_POST['colleges5p15'];
    		$s5p16 = $_POST['colleges5p16'];
    		$s5p17 = $_POST['colleges5p17'];
    		$s5p19 = $_POST['colleges5p19'];
    		
    		$s6ip = $_POST['colleges6ip'];
    		$s6p1 = $_POST['colleges6p1'];
    		$s6p2 = $_POST['colleges6p2'];
    		$s6p3 = $_POST['colleges6p3'];
    		$s6p4 = $_POST['colleges6p4'];
    		$s6p5 = $_POST['colleges6p5'];
    		$s6p6 = $_POST['colleges6p6'];
    		$s6p7 = $_POST['colleges6p7'];
    		$s6p8 = $_POST['colleges6p8'];
    		$s6p9 = $_POST['colleges6p9'];
    		$s6p10 = $_POST['colleges6p10'];
    		$s6p11 = $_POST['colleges6p11'];
    		$s6p12 = $_POST['colleges6p12'];
    		$s6p3to12 = $_POST['colleges6p312'];
    		$s6p13 = $_POST['colleges6p13'];
    		$s6p14 = $_POST['colleges6p14'];
    		$s6p15 = $_POST['colleges6p15'];
    		$s6pall = $_POST['colleges6pall'];
    		
    		$s7ip = $_POST['colleges7ip'];
    		$s7p1 = $_POST['colleges7p1'];
    		$s7p2 = $_POST['colleges7p2'];
    		$s7p3 = $_POST['colleges7p3'];
    		
    		$s8ip = $_POST['colleges8ip'];
    		$s8p5 = $_POST['colleges8p5'];
    		$s8p6 = $_POST['colleges8p6'];
    		$s8p7 = $_POST['colleges8p7'];
    		$s8p8 = $_POST['colleges8p8'];
    		$s8p9 = $_POST['colleges8p9'];
    		$s8p10 = $_POST['colleges8p10'];
    		$s8p11 = $_POST['colleges8p11'];
    		$s8p12 = $_POST['colleges8p12'];
    		$s8p13 = $_POST['colleges8p13'];
    		$s8p14 = $_POST['colleges8p14'];
    		
    		$s9ip = $_POST['colleges9ip'];
    		$s9p3 = $_POST['colleges9p3'];
    		$s9p4 = $_POST['colleges9p4'];
    		$s9p5 = $_POST['colleges9p5'];
    		$s9p6 = $_POST['colleges9p6'];
    		$s9p7 = $_POST['colleges9p7'];
    		$s9p8 = $_POST['colleges9p8'];
    		$s9p9 = $_POST['colleges9p9'];
    		$s9p10 = $_POST['colleges9p10'];
    		$s9p11 = $_POST['colleges9p11'];
    		$s9p12 = $_POST['colleges9p12'];

    		$apcip = $_POST['collegeapc'];
    		$apcport = $_POST['collegeapcp1'];
	
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addCollegeRun(
    				$jobid, 
    				$ixia, $tp1, $tp2, $tp3,
    				$s1ip, $s1p1, $s1p2, $s1p3, $s1p4, $s1p5, $s1p6,
    				$s2ip, $s2p1, $s2p2, $s2p3, $s2p4, $s2p5,
    				$s3ip, $s3p1, $s3p2, $s3p3, 
    				$s4ip, $s4p1, $s4p2, $s4p3,
    				$s5ip, $s5p1, $s5p2, $s5p5, $s5p6, $s5p7, $s5p8, $s5p9, $s5p10, $s5p11, $s5p12, $s5p13, $s5p14, $s5p15, $s5p16, $s5p17, $s5p19,
    				$s5p5to14,
    				$s6ip, $s6p1, $s6p2, $s6p3, $s6p4, $s6p5, $s6p6, $s6p7, $s6p8, $s6p9, $s6p10, $s6p11, $s6p12, $s6p13, $s6p14, $s6p15, $s6pall,
    				$s6p3to12,
    				$s7ip, $s7p1, $s7p2, $s7p3,
    				$s8ip, $s8p5, $s8p6, $s8p7, $s8p8, $s8p9, $s8p10, $s8p11, $s8p12, $s8p13, $s8p14,
    				$s9ip, $s9p3, $s9p4, $s9p5, $s9p6, $s9p7, $s9p8, $s9p9, $s9p10, $s9p11, $s9p12,
    				$apcip, $apcport
    				);
    		echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    	}elseif($_POST['dianxingEnvSel']=='oversea'){
    		$job_type = 'oversea';
    		$suite='oversea';
    		$ixia = $_POST['overseaixia'];
    		$tp1 = $_POST['overseatp1'];
    		$tp2 = $_POST['overseatp2'];
    		$tp3 = $_POST['overseatp3'];
    		
    		$s3ip = $_POST['overseas3ip'];
    		$s3p4 = $_POST['overseas3p4'];
    		$s3p5 = $_POST['overseas3p5'];
    		$s3p6 = $_POST['overseas3p6'];
    		
    		$s4ip = $_POST['overseas4ip'];
    		$s4p4 = $_POST['overseas4p4'];
    		$s4p5 = $_POST['overseas4p5'];
   		
    		$s8ip = $_POST['overseas8ip'];
    		$s8p1 = $_POST['overseas8p1'];
    		$s8p2 = $_POST['overseas8p2'];
    		$s8p3 = $_POST['overseas8p3'];
    		$s8p4 = $_POST['overseas8p4'];
    		$s8p5 = $_POST['overseas8p5'];
    		$s8p6 = $_POST['overseas8p6'];
    		$s8p7 = $_POST['overseas8p7'];
    		$s8p8 = $_POST['overseas8p8'];
  
    		$s9ip = $_POST['overseas9ip'];
    		$s9p1 = $_POST['overseas9p1'];
    		$s9p2 = $_POST['overseas9p2'];
    		$s9p3 = $_POST['overseas9p3'];
    		$s9p4 = $_POST['overseas9p4'];
    		
    		$pcip = $_POST['overseapc'];
	
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addOverseaRun(
    				$jobid, 
    				$ixia, $tp1, $tp2, $tp3,
    				$s3ip, $s3p4, $s3p5, $s3p6,
    				$s4ip, $s4p4, $s4p5, 
    				$s8ip, $s8p1, $s8p2, $s8p3, $s8p4, $s8p5, $s8p6, $s8p7, $s8p8,
    				$s9ip, $s9p1, $s9p2, $s9p3, $s9p4, 
    				$pcip
    				);
    		echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";	
    	}elseif($_POST['dianxingEnvSel']=='financial'){
    		$job_type = 'financial';
    		$suite='financial';
    		$ixia = $_POST['financialixia'];
    		$tp1 = $_POST['financialtp1'];
    		$tp2 = $_POST['financialtp2'];
    		
    		$s1ip = $_POST['financials1ip'];
    		$s1p1 = $_POST['financials1p1'];
    		$s1p2 = $_POST['financials1p2'];
    		$s1p3 = $_POST['financials1p3'];
    		$s1p4 = $_POST['financials1p4'];
    		$s1p5 = $_POST['financials1p5'];
    		$s1p6 = $_POST['financials1p6'];
    		$s1p7 = $_POST['financials1p7'];
    		$s1p8 = $_POST['financials1p8'];
    		$s1p9 = $_POST['financials1p9'];
    		$s1p10= $_POST['financials1p10'];
    		$s1p11= $_POST['financials1p11'];
    		$s1p12= $_POST['financials1p12'];
    		$s1p13= $_POST['financials1p13'];
    		$s1p14= $_POST['financials1p14'];
    		$s1p15= $_POST['financials1p15'];
    		$s1p16= $_POST['financials1p16'];
    		$s1p17= $_POST['financials1p17'];
    		$s1p18= $_POST['financials1p18'];
    		$s1p1to18 = $_POST['financials1p118'];
    		$s1p19= $_POST['financials1p19'];
    		$s1p21= $_POST['financials1p21'];
    		$s1p22= $_POST['financials1p22'];
    		$s1p23= $_POST['financials1p23'];
    		$s1p25= $_POST['financials1p25'];
    		$s1p26 = $_POST['financials1p26'];
    		$s1p36 = $_POST['financials1p36'];
    		$s1p47 = $_POST['financials1p47'];
    		
    		$s2ip = $_POST['financials2ip'];
    		$s2p1 = $_POST['financials2p1'];
    		$s2p2 = $_POST['financials2p2'];
    		$s2p3 = $_POST['financials2p3'];
    		$s2p23 = $_POST['financials2p23'];
    		 
    		$s3ip = $_POST['financials3ip'];
    		$s3p1 = $_POST['financials3p1'];
    		$s3p2 = $_POST['financials3p2'];
    		$s3p3 = $_POST['financials3p3'];
    		$s3p14 = $_POST['financials3p14'];
    		
    		$s4ip = $_POST['financials4ip'];
    		$s4p1 = $_POST['financials4p1'];
    		$s4p2 = $_POST['financials4p2'];
    		$s4p3 = $_POST['financials4p3'];
    		
    		$s5ip = $_POST['financials5ip'];
    		
    		$s6ip = $_POST['financials6ip'];
    		$s6p1 = $_POST['financials6p1'];
    		$s6p2 = $_POST['financials6p2'];
    		$s6p3 = $_POST['financials6p3'];
    		
    		$s7ip = $_POST['financials7ip'];
    		$s7p1 = $_POST['financials7p1'];
    		$s7p2 = $_POST['financials7p2'];
    		
    		$apcip = $_POST['financialapc'];
    		$apcport = $_POST['financialapcport'];
    		$pc1 = $_POST['financialpc1'];
    		$pc2 = $_POST['financialpc2'];
    		
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addFinancialRun(
    				$jobid,
    				$ixia, $tp1, $tp2,
    				$pc1, $pc2,
    				$s1ip, $s1p1, $s1p2, $s1p3, $s1p4, $s1p5, $s1p6, $s1p7, $s1p8, $s1p9, $s1p10, $s1p11, $s1p12, $s1p13, $s1p14, $s1p15, $s1p16, $s1p17, $s1p18, $s1p1to18, $s1p19, $s1p21, $s1p22, $s1p23, $s1p25, $s1p26, $s1p36, $s1p47,
    				$s2ip, $s2p1, $s2p2, $s2p3, $s2p23, 
    				$s3ip, $s3p1, $s3p2, $s3p3, $s3p14,
    				$s4ip, $s4p1, $s4p2, $s4p3,
    				$s5ip,
    				$s6ip, $s6p1, $s6p2, $s6p3,
    				$s7ip, $s7p1, $s7p2,
    				$apcip, $apcport
    		);
   		    echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    	}else{
    		 echo "<script> {window.alert('请选择典型环境(校园网、金融 或 海外运营商)');location.href='/lib/execute/dcnExecution.php'} </script>";
    	}
    }elseif( $job_type == 'softperformance' ){
    	switch($_POST['performanceSel']){
    		case '1':
    			$job_type = 'IGMPSnp性能';
    			$suite='IgmpSnooping处理性能';
    			break;
    		case '2':
	    		$job_type = 'IGMPSnp时延';
    			$suite='IgmpSnooping时延';
    			break;
    		case '3':
	    		$job_type = '协议收包缓冲';
    			$suite='协议收包缓冲区长度';
    			break;
    		case '4':
	    		$job_type = '板间协议处理';
    			$suite='板间协议处理能力';
    			break;
    		default:
    			$job_type = 'softperformance';
    			$suite='软件性能测试';
    			break;
    	}
    	
    	if($_POST['performanceSel']=='1' || $_POST['performanceSel']=='2' || $_POST['performanceSel']=='3'){
    		$ixiaip = $_POST['performance1ixia'];
    		$ixiaport = $_POST['performance1tp'];
    		$s1ip = $_POST['performance1s1ip'];
    		$s1port = $_POST['performance1s1port'];
    	
   	 		$trial = $_POST['performance1trial'];
    		$interval = $_POST['performance1interval'];
    		$debug = $_POST['performance1debug'];
    		$detail = $_POST['par_detail'];
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addPerformanceRun(
    				$jobid,
    				$ixiaip, $ixiaport,null,
    				$s1ip, $s1port,
    				$trial, $interval, $debug,$detail);
    		echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    	}
    	
    	if($_POST['performanceSel']=='4'){
    		$ixiaip = $_POST['performance2ixia'];
    		$ixiaport_num = $_POST['performance2tpnum'];
    		$ixiaport = $_POST['performance2tp'];
    		$s1ip = $_POST['performance2s1ip'];
    		$s1port = $_POST['performance2s1port'];
    		 
    		$trial = $_POST['performance2trial'];
    		$interval = $_POST['performance2interval'];
    		$debug = $_POST['performance2debug'];
    		$detail = $_POST['par_detail'];
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addPerformanceRun(
    				$jobid,
    				$ixiaip, $ixiaport,$ixiaport_num,
    				$s1ip, $s1port,
    				$trial, $interval, $debug,$detail);
    		echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    	}
    	
    }elseif( $job_type == 'function' ){
    	$mindex = 1;
    	$total_case = 0;
    	foreach( $_POST as $pkey => $pvalue ){
    		if( preg_match("/^func_([a-z|A-Z|0-9|_|-].*)/i" , $pkey , $myitemp) ){
    			$case =  $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,$myitemp[1]);
    			$total_case += $case;
    			if( $case != 0 ){
    				if($mindex == 1){ 
    					$module = $myitemp[1];
    				}else{  
    					$module .= "|" . $myitemp[1];
    				}
    				$mindex++;
    			}
    		}
    	}
    	$suite = "(" . $module . ")";
    	if($total_case == 0){
    		echo "<script> {window.alert('该版本上所选模块没有制定覆盖策略(模块测试例为0)，请检查');location.href='/lib/dcnJobs/jobsView.php?div=now'} </script>";
    	}else{
    		$platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
    		$platform_mgr->addFunctionRun($jobid,$_POST['functionEnvSel'],$module,$_POST['function_env_detail'],$_POST['function_env_detail_adv']);
    		echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    	}
    }elseif( $job_type == 'cmdauto' ){
       $s1ip = $_POST['cmdautos1ip'];
       $platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
       $platform_mgr->addCmdAutoRun($jobid, $s1ip);
       
       echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    }elseif( $job_type == 'memorytest' ){
       $s1ip = $_POST['memorytests1ip'];
       $details = $_POST['memorytestdetails'];
       $platform_mgr->addJob($jobid, $platform, $job_type, $total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name, $client_ip,$suite);
       $platform_mgr->addMemoryTesttRun($jobid, $s1ip, addslashes($details));
       
       echo "<script> {parent.treeframe.location.href='dcnrdc://{$jobid}';this.location.href='/lib/dcnJobs/jobsView.php?div=now';} </script>";
    }
    return 0;
}

function init_args()
{
	$args = new stdClass();
	$args->testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
	$args->currentUser = $_SESSION['currentUser']; 
	$args->productline_id = $_COOKIE['job_productline_id'];
	$args->tplan_id = $_COOKIE['job_tplan_id'];
	$args->build_id = $_COOKIE['job_build_id'];
	$args->device_id = $_COOKIE['job_device_id'];
	$args->user_name = $_COOKIE['job_user_name'];

	return $args;
}

function getIP()
{
	global $_SERVER;
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} else if (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} else if (getenv('REMOTE_ADDR')) {
		$ip = getenv('REMOTE_ADDR');
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function checkRights(&$db,&$user)
{
	return True;
}

?>
