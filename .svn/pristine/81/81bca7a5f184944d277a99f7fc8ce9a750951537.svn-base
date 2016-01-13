<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$templateCfg = templateConfiguration();
$args = init_args();

$platform_mgr = new tlPlatform($db, $args->testproject_id);
$total_case =  array();
$total_case['total'] = 0;
$client_ip = getIP();
$client_at = 'bj';

$gui = new stdClass();
$jobid = 'cloud' . (string)time();

if( $_FILES['img_file']['error'] > 0 ){
	switch($_FILES['img_file']['error']){
		case 1:
		case 2:
			$message = "Error : 上传文件过大，超出服务器或浏览器限制!" ;
			break;
		case 3:
			$message = "Error : 文件不完整，仅成功上传部分文件!" ;
			break;
		case 4:
			$message = "Error : 别逗我,你没有上传img文件!" ;
			break;
		case 5:
		case 6:
			$message = "Error : 服务器临时文件丢失或写临时文件出错!" ;
			break;		
	}
	echo "<script>{window.alert('{$message}');self.location.href='/lib/execute/dcnCloudExecution.php';} </script>";
	return 0;
}elseif( (preg_match("/^.*?\.img/i" , $_FILES['img_file']['name'] , $temp))==0 ){
	echo "<script>{window.alert('您上传的不是img文件，请确认!');self.location.href='/lib/execute/dcnCloudExecution.php';} </script>";
	return 0;
}else{
	$total_module = 0;
	$topo_type = $_POST['topotype'];

	switch( $topo_type ){
		case 'affirm2':
    		if( isset($_POST['affirm2']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['affirm2'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'确认测试2.0','all');
    		}
    		break;
   		case 'affirm3':
   			if( isset($_POST['affirm3']) ){
   				$total_module++ ;
   				$total_case['total'] += $total_case['affirm3'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'确认测试3.0','all');
   			}
			break;
    		
		case 'college':
			if( isset($_POST['college']) ){
				$total_module++ ;
				$total_case['total'] += $total_case['college'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'college','all');
			}
			break;
  			
		case 'oversea':
			if( isset($_POST['oversea']) ){
				$total_module++ ;
				$total_case['total'] += $total_case['oversea'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'oversea','all');
			}
    		break;
    	
   	 	case 'financial':
    		if( isset($_POST['financial']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['financial'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'financial','all');
    		}
  	  		break;
    			
   	 	case 'function':
   	 		//line1
    		if( isset($_POST['Aggregation']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Aggregation'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Aggregation','all');
    		}
    		if( isset($_POST['Am']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Am'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Am','all');
    		}
    		if( isset($_POST['Arp']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Arp'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Arp','all');
    		}
    		if( isset($_POST['ArpGuard']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['ArpGuard'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'ArpGuard','all');
    		}
    		if( isset($_POST['DCSCM']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['DCSCM'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'DCSCM','all');
    		}
    		if( isset($_POST['DhcpSnooping']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['DhcpSnooping'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'DhcpSnooping','all');
    		}
    		//line2
    		if( isset($_POST['DynamicVlan']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['DynamicVlan'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'DynamicVlan','all');
    		}
    		if( isset($_POST['FBR']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['FBR'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'FBR','all');
    		}
    		if( isset($_POST['GratuitousArp']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['GratuitousArp'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'GratuitousArp','all');
    		}
    		if( isset($_POST['Icmpv6']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Icmpv6'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Icmpv6','all');
    		}
    		if( isset($_POST['IgmpSnooping']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IgmpSnooping'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IgmpSnooping','all');
    		}
    		if( isset($_POST['IPv4ACL']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv4ACL'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv4ACL','all');
    		}
    		//line3
    		if( isset($_POST['IPv4Icmp']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv4Icmp'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv4Icmp','all');
    		}
    		if( isset($_POST['Ipv4Ipv6Host']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Ipv4Ipv6Host'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Ipv4Ipv6Host','all');
    		}
    		if( isset($_POST['IPv4StaticRoute']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv4StaticRoute'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv4StaticRoute','all');
    		}
    		if( isset($_POST['IPv4v6BlackHoleRoute']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv4v6BlackHoleRoute'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv4v6BlackHoleRoute','all');
    		}
    		if( isset($_POST['IPv6ACL']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv6ACL'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv6ACL','all');
    		}
    		if( isset($_POST['IPv6Address']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv6Address'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv6Address','all');
    		}
    		//line4
    		if( isset($_POST['IPv6ND']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv6ND'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv6ND','all');
    		}
    		if( isset($_POST['Ipv6StaticRouting']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Ipv6StaticRouting'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Ipv6StaticRouting','all');
    		}
    		if( isset($_POST['IPv6VRRP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IPv6VRRP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IPv6VRRP','all');
    		}
    		if( isset($_POST['IsolatePort']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['IsolatePort'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'IsolatePort','all');
    		}
    		if( isset($_POST['KeepAliveGateway']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['KeepAliveGateway'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'KeepAliveGateway','all');
    		}
    		if( isset($_POST['L2']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['L2'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'L2','all');
    		}
    		//line5
    		if( isset($_POST['lldp']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['lldp'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'lldp','all');
    		}
    		if( isset($_POST['LocalProxyARP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['LocalProxyARP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'LocalProxyARP','all');
    		}
    		if( isset($_POST['LoopbackDetection']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['LoopbackDetection'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'LoopbackDetection','all');
    		}
    		if( isset($_POST['Mirror']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['Mirror'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'Mirror','all');
    		}
    		if( isset($_POST['MRPP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['MRPP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'MRPP','all');
    		}
    		if( isset($_POST['MSTP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['MSTP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'MSTP','all');
    		}
    		//line6
    		if( isset($_POST['PortChannel']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['PortChannel'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'PortChannel','all');
    		}
    		if( isset($_POST['PortStatistic']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['PortStatistic'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'PortStatistic','all');
    		}
    		if( isset($_POST['PortVlanIpLimit']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['PortVlanIpLimit'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'PortVlanIpLimit','all');
    		}
    		if( isset($_POST['PreventARPSboofing']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['PreventARPSboofing'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'PreventARPSboofing','all');
    		}
    		if( isset($_POST['PreventNDSboofing']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['PreventNDSboofing'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'PreventNDSboofing','all');
    		}
    		if( isset($_POST['RateViolation']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['RateViolation'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'RateViolation','all');
    		}
    		//line7
    		if( isset($_POST['RSPAN']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['RSPAN'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'RSPAN','all');
    		}
    		if( isset($_POST['SecurityRA']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['SecurityRA'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'SecurityRA','all');
    		}
    		if( isset($_POST['ULPP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['ULPP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'ULPP','all');
    		}
    		if( isset($_POST['VLAN']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['VLAN'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'VLAN','all');
    		}
    		if( isset($_POST['VlanACL']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['VlanACL'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'VlanACL','all');
    		}
    		if( isset($_POST['VRRP']) ){
    			$total_module++ ;
    			$total_case['total'] += $total_case['VRRP'] = $platform_mgr->getJobTotalCase($args->tplan_id, $args->device_id,'VRRP','all');
    		}
    		break;
	}

	if( $total_module == 0 ){
		echo "<script>{window.alert('没有选择任何模块，请选择需要云端执行的自动化模块..');self.location.href='/lib/execute/dcnCloudExecution.php'} </script>";
	}elseif( $total_case['total'] == 0 ){
		echo "<script>{window.alert('该设备上所选模块没有制定覆盖策略(模块测试例为0)，请检查!');self.location.href='/lib/execute/dcnCloudExecution.php'} </script>";
	}else{
		if( preg_match("/^192.168.6(.*?)/i" , getIP() , $temp) ){
			$client_at = 'wh';
		}elseif( preg_match("/^192.168.5(.*?)/i" , getIP() , $temp)){
			$client_at = 'bj';
		}else{
			echo "<script>{window.alert('请在VDI内访问TestLink服务器进行测试!');self.location.href='/lib/execute/dcnCloudExecution.php'} </script>";		
		}
		if($client_at == 'bj'){
			$conn = ftp_connect("192.168.50.209") or die("Could not connect");
		}else{
			$conn = ftp_connect("192.168.60.209") or die("Could not connect");
		}
		ftp_login($conn,"ftp","123456");
		ftp_chdir($conn,"simulator/img");
		ftp_put($conn,$jobid.'.img',$_FILES['img_file']['tmp_name'],FTP_BINARY);
		ftp_close($conn);
		//move_uploaded_file($_FILES['img_file']['tmp_name'],'../../upload_area/exec_logs/upload_imgs/' . $jobid . '.img' );
  	    //分解任务为单个模块
    	foreach($total_case as $module=>$module_total_case){
    		if($module != 'total' && $module_total_case != 0){
    			$sub_jobid = $jobid .'-'. $module;
    			$platform_mgr->addCloudJob($sub_jobid,$client_at,$topo_type, $module, $module_total_case, $args->productline_id, $args->tplan_id, $args->device_id, $args->build_id, $args->user_name);
    		}
    	}
    	echo "<script> {this.location.href='/lib/dcnJobs/jobsView.php?div=cloud';} </script>";
    	return 0;
	}
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