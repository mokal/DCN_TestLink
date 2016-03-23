<?php
/**
 * TestLink Open Source Project - http://testlink.sourceforge.net/
 * This script is distributed under the GNU General Public License 2 or later.
 *
 * @filesource  tlPlatform.class.php
 * @package     TestLink
 * @author      Erik Eloff
 * @copyright   2006-2012, TestLink community
 * @link        http://www.teamst.org/index.php
 *
 * @internal revisions
 * @ since 1.9.6
 */

/**
 * Class for handling platforms
 * @author Eloff
 **/
class tlPlatform extends tlObjectWithDB
{
  protected $tproject_id;

  const E_NAMENOTALLOWED = -1;
  const E_NAMELENGTH = -2;
  const E_NAMEALREADYEXISTS = -4;
  const E_DBERROR = -8;
  const E_WRONGFORMAT = -16;


  /**
   * @param $db database object
   * @param $tproject_id to work on. If null (default) the project in session
   *                     is used
     * DO NOT USE this kind of code is not accepted have this kind of global coupling
     * for lazy users
   */
  public function __construct(&$db, $tproject_id = null)
  {
    parent::__construct($db);
    $this->tproject_id = $tproject_id;
  }

  /**
   * 
   * 
   */
  public function setTestProjectID($tproject_id)
  {
    $this->tproject_id = intval($tproject_id);  
  }


  /**
   * Creates a new platform.
   * @return tl::OK on success otherwise E_DBERROR;
   */
  public function create($name, $supportl3, $isboxswitch, $linespeed,$affirm2devicegroup,$affirm3devicegroup,$functiondevicegroup,$performance_id,$notes=null)
  {
    $op = array('status' => self::E_DBERROR, 'id' => -1);
    $safeName = $this->throwIfEmptyName($name);
    $alreadyExists = $this->getID($name);
    if ($alreadyExists)
    {
      $op = array('status' => self::E_NAMEALREADYEXISTS, 'id' => -1);
    }
    else
    {
      $sql = "INSERT INTO {$this->tables['platforms']} " .
             "(name, testproject_id, supportl3, isboxswitch, linespeed,affirm2_var,affirm3_var,function_var,performance_id, notes) " .
             " VALUES ('" . $this->db->prepare_string($safeName) . 
             "', $this->tproject_id, $supportl3, $isboxswitch, $linespeed,$affirm2devicegroup,$affirm3devicegroup,$functiondevicegroup,$performance_id, '".$this->db->prepare_string($notes)."')";
      $result = $this->db->exec_query($sql);

      if( $result )
      {
        $op['status'] = tl::OK;
        $op['id'] = $this->db->insert_id($this->tables['platforms']);
      } 
    }
    return $op;
  }

public function createIssue($testcase, $step, $product, $script, $comment)
  {
    $op = array('status' => self::E_DBERROR, 'id' => -1);

	$sql = "INSERT INTO acceptablebugs " .
           "(product, testcase, failedsteps, script_version, comment) " .
           "VALUES ('$product', '$testcase', '$step', '$script', '$comment')";
    $result = $this->db->exec_query($sql);
    if( $result )
    {
      $op['status'] = tl::OK;
      $op['id'] = $this->db->insert_id(acceptablebugs);
    }
    return $op;
  }
  
  /**
   * Gets all info of a platform
   *
   * @return array with keys id, name and notes
   */
  public function getByID($id)
  {
    $sql =  " SELECT * " .
            " FROM {$this->tables['platforms']} " .
            " WHERE id = " . intval($id);
    return $this->db->fetchFirstRow($sql);
  }

  public function getIssueByID($id)
  {
    $sql =  " SELECT id, product, script_version, testcase, failedsteps, comment " .
            " FROM acceptablebugs " .
            " WHERE productline_id = {$this->tproject_id} AND id = " . intval($id);
    return $this->db->fetchFirstRow($sql);
  }


  public function matchIssueByID($productline_id, $product, $script, $testcase, $step)
  {
    $sql =  " SELECT comment " .
            " FROM acceptablebugs " .
            " WHERE productline_id = '{$productline_id}' AND " .
            " product = '{$product}' AND " .
            " script_version = '{$script}' AND " .
            " testcase = '{$testcase}' AND " .
            " failedsteps = '{$step}' " ;

    $rs = $this->db->get_recordset($sql);
	if(is_null($rs)){
	    return -1;
	}
	else{
        return $rs[0];
    }
  }

  public function getOldDiff($jobid, $tcid)
  {
  	$sql =  " SELECT * FROM running_jobs WHERE job_id='{$jobid}' " ;
    $job = $this->db->get_recordset($sql);
  	if( is_null($job) ){
  		return 'none';
  	}else{
  		$job = $job[0] ;
  		$sql = " SELECT id FROM builds WHERE testplan_id={$job['tplan_id']} AND id < {$job['build_id']}  ORDER BY id DESC" ;
  		$buildid = $this->db->get_recordset($sql);
  		if( is_null($buildid) ){
  			return 'none';
  		}else{
  			$buildid = $buildid[0];
  		    $sql = " SELECT id FROM nodes_hierarchy WHERE parent_id = {$tcid} " ;
  		    $tcversion_id = $this->db->fetchFirstRow($sql);
  		
  	   	    $sql =  " SELECT fail_type FROM executions " .
    	       	    " WHERE testplan_id = {$job['tplan_id']} " .
    	    	    " AND platform_id = {$job['device_id']} " .
    	    	    " AND build_id = {$buildid['id']} " .
  				    " AND stack = {$job['topo_type']} " .
  				    " AND status != 'p' " .
  				    " AND tcversion_id = {$tcversion_id['id']} " ;
  		    $rs = $this->db->get_recordset($sql);
  		    if( is_null($rs) ){
  			    return 'none';
  		    }else{
  			    return $rs[0]['fail_type'];
  		    }
  	    }
  	}
  }
    
  public function createJob($testplan,$device,$build)
  {
   //get test plan id
    $tempsql = " SELECT id FROM {$this->tables['nodes_hierarchy']} WHERE node_type_id = 5 and name = '{$testplan}' ";
    $exec = $this->db->get_recordset($tempsql);
    $testplan_id = $exec[0]['id'];  

   //get build id
    $tempsql = " SELECT id FROM {$this->tables['builds']} WHERE  testplan_id = {$testplan_id} and name = '{$build}' ";
    $exec = $this->db->get_recordset($tempsql);
    $build_id = $exec[0]['id'];

    //get device id
    $tempsql = " SELECT id FROM {$this->tables['platforms']} WHERE  name = '{$device}' ";
    $exec = $this->db->get_recordset($tempsql);
    $device_id = $exec[0]['id'];

  //  $sql = " INSERT INTO running_jobs (job_id,job_type,productline_id,tplan_id,device_id,build_id,total_case) VALUES () " ;
  //  return 1;
   }

  public function getJobInfo($jobid)
  { 
  	if( preg_match("/^cloud(.*?)/i" , $jobid , $temp) ){
  		$sql =  " SELECT job_id,topo_type,topo_type as job_type,module,productline_id as productLine , tplan_id as testPlan, build_id as testBuild, device_id as testDevice, user_id as user" .
  				" FROM run_cloud_jobs WHERE job_id = '{$jobid}'" ;
  	}else{
    	$sql =  " SELECT job_id, job_type, productline_id as productLine , tplan_id as testPlan, build_id as testBuild, device_id as testDevice, user_id as user" .
        	    " FROM running_jobs WHERE job_id = '{$jobid}'" ;
  	}
    $rs = $this->db->fetchFirstRow($sql);
    if($rs != False){
    	if( $rs['job_type']=='IGMPSnp性能' || $rs['job_type']=='IGMPSnp时延' || $rs['job_type']=='协议收包缓冲' || $rs['job_type']=='板间协议处理' ){
    		$rs['job_type'] = 'softP_' . $rs['job_type'];
    	}
    	//get productline name
    	$tempsql = " SELECT name FROM {$this->tables['nodes_hierarchy']} WHERE node_type_id = 1 and id = {$rs['productLine']} ";
    	$exec = $this->db->get_recordset($tempsql);
    	$rs['productLine'] = $exec[0]['name'];

    	//get build name
    	$tempsql = " SELECT name FROM {$this->tables['builds']} WHERE  testplan_id = {$rs['testPlan']} and id = {$rs['testBuild']} ";
    	$exec = $this->db->get_recordset($tempsql);
    	$rs['testBuild'] = $exec[0]['name'];

    	//get test plan name
    	$tempsql = " SELECT name FROM {$this->tables['nodes_hierarchy']} WHERE  node_type_id = 5 and id = {$rs['testPlan']} ";
    	$exec = $this->db->get_recordset($tempsql);
   		$rs['testPlan'] = $exec[0]['name'];
   		
    	//get device name
    	$tempsql = " SELECT name FROM {$this->tables['platforms']} WHERE  id = {$rs['testDevice']} ";
    	$exec = $this->db->get_recordset($tempsql);
 	    $rs['testDevice'] = $exec[0]['name'];
 	    $rs['device_typeid'] = end(explode('-', $rs['testDevice']));

 	    //get user name
    	$tempsql = " SELECT login FROM {$this->tables['users']} WHERE  id = {$rs['user']} ";
    	$exec = $this->db->get_recordset($tempsql);
    	$rs['user'] = $exec[0]['login'];
    	
    	//if function return modules
    	if( $rs['job_type'] == 'function' && !isset($rs['module']) ){
    		$tempsql = " SELECT modules FROM function_exec_record WHERE job_id='{$jobid}' ";
    		$exec = $this->db->get_recordset($tempsql);
    		$temp = explode('|', $exec[0]['modules']);
    		$rs['module'] = array();
    		for( $index=0 ; $index < count($temp) ; $index++ ){
    			$rs['module'][] = $temp[$index];	
    		}
    	}
    	return $rs;
    }else{ 
    	return -1;
    }
  }

  public function getJobEnv($jobid)
  {
  	if( preg_match("/^cloud(.*?)/i" , $jobid , $temp) ){
  		$job_type = 'cloud';
  		$sql =  " SELECT tplan_id FROM run_cloud_jobs WHERE job_id = '{$jobid}'" ;
  		$rs = $this->db->fetchFirstRow($sql);
  	}else{
        $sql =  " SELECT job_type,tplan_id FROM running_jobs WHERE job_id = '{$jobid}'" ;
        $rs = $this->db->fetchFirstRow($sql);
        $job_type = $rs['job_type'];
  	}
  	$sql = " SELECT script_tag FROM {$this->tables['testplans']} WHERE id = {$rs['tplan_id']} ";
  	$script_tag = $this->db->fetchFirstRow($sql); 	
  	
    switch($job_type){
        case 'affirm2':
             $sql =  " SELECT * FROM affirm2_exec_record WHERE job_id = '{$jobid}' ";
             $env =  $this->db->fetchFirstRow($sql);
             $sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
             $device =  $this->db->fetchFirstRow($sql);
             $sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
             $device =  $this->db->fetchFirstRow($sql);
             break; 
        case 'affirm3':
        	$sql =  " SELECT * FROM affirm3_exec_record WHERE job_id = '{$jobid}' ";
        	$env =  $this->db->fetchFirstRow($sql);
        	$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
        	$device =  $this->db->fetchFirstRow($sql);
        	$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
        	$device =  $this->db->fetchFirstRow($sql);
        	break;
        case 'affirm3|affirm2':
            $sql =  " SELECT * FROM affirm3_exec_record WHERE job_id = '{$jobid}' ";
            $env =  $this->db->fetchFirstRow($sql);
            $env['productVersion'] = '' ;
            $env['scriptVersion'] = '' ;
            $sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
            $device =  $this->db->fetchFirstRow($sql);
            $sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
            $device =  $this->db->fetchFirstRow($sql);
            break; 
        case 'waffirm':
        case 'waffirm_X86':
           	$sql =  " SELECT * FROM affirmwireless_exec_record WHERE job_id = '{$jobid}' ";
           	$env =  $this->db->fetchFirstRow($sql);
           	$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
           	$device =  $this->db->fetchFirstRow($sql);
           	$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
           	$device =  $this->db->fetchFirstRow($sql);
           	break; 
        case 'college':
         	$sql =  " SELECT * FROM a_college_exec_record WHERE job_id = '{$jobid}' ";
         	$env =  $this->db->fetchFirstRow($sql);
            $sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
            $device =  $this->db->fetchFirstRow($sql);
            $sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
            $device =  $this->db->fetchFirstRow($sql);
            break;  
        case 'financial':
          	$sql =  " SELECT * FROM a_financial_exec_record WHERE job_id = '{$jobid}' ";
           	$env =  $this->db->fetchFirstRow($sql);
           	$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
           	$device =  $this->db->fetchFirstRow($sql);
           	$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
           	$device =  $this->db->fetchFirstRow($sql);
           	break;	            	
       	case 'oversea':
       		$sql =  " SELECT * FROM a_oversea_exec_record WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		break;
       	case 'IGMPSnp性能':
       	case 'IGMPSnp时延':
       	case '协议收包缓冲':
       	case '板间协议处理':
       		$sql =  " SELECT * FROM v_performance_exec_record WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		break;
       	case 'cloud':
       		$sql =  " SELECT env_id,device_id,module,env_details as details FROM run_cloud_jobs WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		if( $env['env_id'] == 'docker' ){
       			$sql =  " SELECT details FROM run_cloud_virtual_envs WHERE module = '{$env['module']}' ";
       			$rs =  $this->db->fetchFirstRow($sql);
       			$env['details'] = $env['details'] . "\n" . $rs['details'] ;
       		}else{
       			$sql =  " SELECT details FROM run_cloud_envs WHERE id = '{$env['env_id']}' ";
       			$rs =  $this->db->fetchFirstRow($sql);
       			$env['details'] = $rs['details'];
       		}
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$env['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		break;
       	case 'function':
       		$sql =  " SELECT * FROM function_exec_record WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed,function_var FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name FROM vars WHERE id = {$device['function_var']}";
       		$varname =  $this->db->fetchFirstRow($sql);
       		
       		$temp = explode('-', $env['env_id']);
       		$env['dsend_port'] = $temp[1];
       		unset($env['env_id']);
       		
       		$device['function_var'] = $varname['name'];
       		$env['details'] = "GroupTopologyName   " . $varname['name'] . "\n" . $env['details']; 
       		break;
       	case 'cmdauto':
       		$sql =  " SELECT * FROM a_cmd_exec_record WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		break;
       case 'memorytest':
       		$sql =  " SELECT * FROM a_memorytest_exec_record WHERE job_id = '{$jobid}' ";
       		$env =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT device_id FROM running_jobs WHERE job_id = '{$jobid}' ";
       		$device =  $this->db->fetchFirstRow($sql);
       		$sql =  " SELECT name, supportl3, isboxswitch, linespeed FROM {$this->tables['platforms']} WHERE id = {$device['device_id']}";
       		$device =  $this->db->fetchFirstRow($sql);
       		break;
        default:
        	break;
      }
      if($script_tag['script_tag'] != 'aftersale'){
      		$env['scriptVersion'] = $script_tag['script_tag'];
      }
      return array_merge($device, $env);
  }

  public function getJobCases($jobid)
  {
  	$docker_not_support='lldp_5.2.2.6.tcl-lldp_5.2.3.7.tcl-lldp5.2.3.11.tcl-lldp_5.2.5.3.tcl-lldp_6.2.tcl-lldp_6.3.tcl-lldp_6.4.tcl-lldp_6.5.tcl-lldp_6.6.tcl-lldp_6.7.tcl-lldp_6.8.tcl-lldp_6.9.tcl-lldp_8.1.tcl-lldp_8.2.tcl';
  	$docker_not_support.='VRRP_5.2.7.2.tcl-VRRP_6.1.1.tcl-VRRP_6.3.tcl-VRRP_6.4.tcl-VRRP_6.5.tcl-VRRP_6.6.tcl-VRRP_6.7.tcl-VRRP_6.8.tcl-VRRP_7.1.tcl-VRRP_7.2.tcl-VRRP_7.3.tcl';
  	$docker_not_support.='Ipv4Ipv6Host_5.2.4.tcl-Ipv4Ipv6Host_5.2.5.tcl-Ipv4Ipv6Host_5.2.7.tcl-Ipv4Ipv6Host_5.2.10.tcl-Ipv4Ipv6Host_5.2.13.tcl-Ipv4Ipv6Host_5.2.14.3.tcl-Ipv4Ipv6Host_5.2.15.tcl-Ipv4Ipv6Host_5.2.8.3.tcl';
  	if( preg_match("/^cloud(.*?)/i" , $jobid , $tempa) ){
  		$sql = " SELECT tplan_id, device_id, module as job_type,env_id FROM run_cloud_jobs WHERE job_id = '{$jobid}'" ;
  	}else{
        $sql = " SELECT tplan_id, device_id, job_type FROM running_jobs WHERE job_id = '{$jobid}'" ;
  	}
  	$exec = $this->db->fetchFirstRow($sql);
  	
  	$platform = 'all';
  	if($exec['job_type'] == 'affirm2'){
  		$sql = " SELECT platform FROM affirm2_exec_record WHERE job_id = '{$jobid}'" ;
  		$atemp = $this->db->fetchFirstRow($sql);
  		$platform = $atemp['platform'];
  	}
  	
  	if($platform == 'moni'){
  		$sql =  " SELECT TPTCV.id as tptcid,TPTCV.skip,TPTCV.tcversion_id,TCV.preconditions " .
  		 		" FROM testplan_tcversions as TPTCV, tcversions as TCV " .
  		 		" WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id ={$exec['tplan_id']} AND TPTCV.platform_id = {$exec['device_id']} AND TPTCV.active=1 AND TCV.preconditions LIKE '%.tcl' ";
  	}elseif($platform == 'dauto'){
  		$sql =  " SELECT TPTCV.id as tptcid,TPTCV.skip,TPTCV.tcversion_id,TCV.preconditions " .
  		 		" FROM testplan_tcversions as TPTCV, tcversions as TCV " .
  		 		" WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id ={$exec['tplan_id']} AND TPTCV.platform_id = {$exec['device_id']} AND TPTCV.active=1 AND TCV.preconditions LIKE '%.py' ";
  	}else{
  		$sql =  " SELECT TPTCV.id as tptcid,TPTCV.skip,TPTCV.tcversion_id,TCV.preconditions " .
  				" FROM testplan_tcversions as TPTCV, tcversions as TCV " .
  				" WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id ={$exec['tplan_id']} AND TPTCV.platform_id = {$exec['device_id']} AND TPTCV.active=1 ";
  	}
  	$cases = $this->db->get_recordset($sql);
   
    $returnrs = array();
    foreach($cases as $testcase){
         $sql =  " SELECT parent_id FROM nodes_hierarchy WHERE id= {$testcase['tcversion_id']} " ;
         $rs = $this->db->fetchFirstRow($sql);
         $temp['testcase_id'] = $rs['parent_id'];
       
         $sql =  " SELECT parent_id,name FROM nodes_hierarchy WHERE id= {$temp['testcase_id']} " ;
         $rs = $this->db->fetchFirstRow($sql);
         $temp['name'] = $rs['name'];

         $sql =  " SELECT name FROM nodes_hierarchy WHERE id= {$rs['parent_id']} " ;
         $rs = $this->db->fetchFirstRow($sql);

         switch($exec['job_type']){
             case 'affirm2':
                 if($rs['name'] == '确认测试2.0'){
                    	if($testcase['skip'] != 1){
                            $temp['suite'] = $rs['name'];
                            $temp['script'] = $testcase['preconditions'];
                           	array_push($returnrs, $temp);
                       	 }else{
                       	   	$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                       	   	$this->db->exec_query($sql);
                       	 }
                 };
                 break;

             case 'affirm3':
                 if($rs['name'] == '确认测试3.0' ){
                     if($testcase['skip'] != 1){
                         $temp['suite'] = $rs['name'];
             		     $temp['script'] = $testcase['preconditions'];
                    	 array_push($returnrs, $temp);
                     }else{
                         $sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                       	 $this->db->exec_query($sql);
                     }
                 };
                 break;

             case 'affirm3|affirm2':
                 if( ($rs['name'] == '确认测试3.0') or ($rs['name'] == '确认测试2.0') ){
                   	 if($testcase['skip'] != 1){
                         $temp['suite'] = $rs['name'];
                         $temp['script'] = $testcase['preconditions'];
                         array_push($returnrs, $temp);
                   	 }else{
                     	 $sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                       	 $this->db->exec_query($sql);
                     }
                 };
                 break;                       
             case 'waffirm':
                 if( $rs['name'] == 'waffirm' ){
                     if($testcase['skip'] != 1){
                         $temp['suite'] = $rs['name'];
                       	 $temp['script'] = $testcase['preconditions'];
                       	 array_push($returnrs, $temp);
                      }else{
                          $sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                          $this->db->exec_query($sql);
                      }
                  };
                  break;
                  
              case 'waffirm_X86':
                  if( $rs['name'] == 'waffirm_X86' ){
                      if($testcase['skip'] != 1){
                  	      $temp['suite'] = $rs['name'];
                  		  $temp['script'] = $testcase['preconditions'];
                  		  array_push($returnrs, $temp);
                  	   }else{
                  		  $sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  		  $this->db->exec_query($sql);
                  	   }
                    };
                  	break;
                  	
               case 'IGMPSnp性能':
                 	if( $rs['name'] == 'IgmpSnooping处理性能' ){
                 		if($testcase['skip'] != 1){
                 			$temp['suite'] = $rs['name'];
                 			$temp['script'] = $testcase['preconditions'];
                 			array_push($returnrs, $temp);
                 		}else{
                 			$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                 			$this->db->exec_query($sql);
                 		}
                 	};
                 	break;
                  		 		
                  case 'IGMPSnp时延':
                  	if( $rs['name'] == 'IgmpSnooping时延' ){
                  		if($testcase['skip'] != 1){
                  			$temp['suite'] = $rs['name'];
                  			$temp['script'] = $testcase['preconditions'];
                  			array_push($returnrs, $temp);
                  		}else{
                  			$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  			$this->db->exec_query($sql);
                  		}
                  	};
                  	break;
                  						
                  case '协议收包缓冲':
                  	if( $rs['name'] == '协议收包缓冲区长度' ){
                  		if($testcase['skip'] != 1){
                  			$temp['suite'] = $rs['name'];
                  			$temp['script'] = $testcase['preconditions'];
                  			array_push($returnrs, $temp);
                  		}else{
                  			$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  			$this->db->exec_query($sql);
                  		}
                  	};
                  	break;			
                  				
                  case '板间协议处理':
                  	if( $rs['name'] == '板间协议处理能力' ){
                  		if($testcase['skip'] != 1){
                  			$temp['suite'] = $rs['name'];
                  			$temp['script'] = $testcase['preconditions'];
                  			array_push($returnrs, $temp);
                  		}else{
                  			$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  			$this->db->exec_query($sql);
                  		}
                  	};
                  	break;
                  	 	
                  case 'function':
                  	$sql =  " SELECT modules FROM function_exec_record WHERE job_id = '{$jobid}'" ;
                  	$modules = $this->db->fetchFirstRow($sql);
                  	if( preg_match("/" . $rs['name'] ."/i",$modules['modules']) ){
                  		if($testcase['skip'] != 1){
                  			$temp['suite'] = $rs['name'];
                  			$temp['script'] = $testcase['preconditions'];
                  			array_push($returnrs, $temp);
                  		}else{
                  			$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  			$this->db->exec_query($sql);
                  		}
                  	}
                  	break;
                  case 'cmdauto':
                  		if($rs['name'] == 'CommandLine'){
                  			if($testcase['skip'] != 1){
                  				$temp['suite'] = $rs['name'];
                  				$temp['script'] = $testcase['preconditions'];
                  				array_push($returnrs, $temp);
                  			}else{
                  				$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  				$this->db->exec_query($sql);
                  			}
                  		};
                  		break;
                  case 'memorytest':
                  		if($rs['name'] == 'MemoryCrash'){
                  			if($testcase['skip'] != 1){
                  				$temp['suite'] = $rs['name'];
                  				$temp['script'] = $testcase['preconditions'];
                  				array_push($returnrs, $temp);
                  			}else{
                  				$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  				$this->db->exec_query($sql);
                  			}
                  		};
                  		break;
                  default:
                  		if( $rs['name'] == $exec['job_type'] ){
                  			if($testcase['skip'] != 1){
                  				$temp['suite'] = $rs['name'];
                  				$temp['script'] = $testcase['preconditions'];
                  				if( !stripos($docker_not_support,$rs['preconditions']) ){
                  					array_push($returnrs, $temp);
                  				}
                  			}else{
                  				$sql =  " UPDATE testplan_tcversions SET skip=0 WHERE id={$testcase['tptcid']} " ;
                  				$this->db->exec_query($sql);
                  			}
                  		};
                  		break;
              }
            }
   return $returnrs;
  }

  public function getTplanDevices($tplanid)
  {
    $sql =  " SELECT TP.platform_id as id,P.name FROM testplan_platforms as TP ,platforms as P WHERE TP.testplan_id ={$tplanid} AND TP.platform_id = P.id  ORDER BY platform_id ASC ";
    $devices = $this->db->get_recordset($sql);
    return $devices ;
  }  

  public function pullCasesFromVar($tplan_id,$device_id,$suite,$username)
  {
  	$sql =  " SELECT id FROM users WHERE login = '{$username}' " ;
  	$userid = $this->db->fetchFirstRow($sql);
  	$userid = $userid['id'];
  	
  	$sql =  " SELECT affirm2_var as affirm2,affirm3_var as affirm3,function_var as function FROM platforms WHERE id={$device_id} ";
  	$device_vars = $this->db->get_recordset($sql);

  	if( !is_null($device_vars[0][$suite])){
  		$var_cases = $testplan_cases = array();
  		$sql =  " SELECT tcversion_id FROM var_tcversions WHERE var_id={$device_vars[0][$suite]} ";
  		$cases = $this->db->fetchRowsIntoMap($sql,'tcversion_id');
  		$var_cases = array_keys($cases);
  		$sql =  " SELECT tcversion_id FROM testplan_tcversions WHERE testplan_id={$tplan_id} AND platform_id={$device_id} ";
  		$cases = $this->db->fetchRowsIntoMap($sql,'tcversion_id');
  		$mycases = array();
  		foreach($cases as $tcv_id=>$case){
  			$sql =  " SELECT SU.name,SU.id FROM nodes_hierarchy as TCV,nodes_hierarchy as TC,nodes_hierarchy as SU " .
  					" WHERE TCV.id={$tcv_id} AND TCV.parent_id=TC.id AND TC.parent_id=SU.id ";
  			$rs = $this->db->fetchFirstRow($sql);
  			switch($suite){
  				case 'affirm2':
  					if( $rs['name'] == '确认测试2.0'){
  						$mycases[$tcv_id] = $case;
  					}
  					break;
  				case 'affirm3':
  					if( $rs['name'] == '确认测试3.0'){
  						$mycases[$tcv_id] = $case;
  					}
  					break;
  				case 'function':
  					$sql =  " SELECT PSU.name FROM nodes_hierarchy as SU,nodes_hierarchy as PSU " .
  							" WHERE SU.id={$rs['id']} AND SU.parent_id=PSU.id ";
  					$rs = $this->db->fetchFirstRow($sql);

  					if( $rs['name'] == '功能测试'){
  						$mycases[$tcv_id] = $case;
  					}
  					break;
  				default:
  					break;
			}
		}
  		$testplan_cases = array_keys($mycases);
  		$need_add = array_diff( $var_cases , $testplan_cases);
  		$need_delete = array_diff( $testplan_cases , $var_cases);
  		if( !is_null($need_add) ){
  			foreach($need_add as $tcv_id){
  				$sql =  " INSERT INTO testplan_tcversions " .
    					" (testplan_id, tcversion_id, platform_id, author_id) " .
    					" VALUES ({$tplan_id},{$tcv_id},{$device_id},{$userid}) " ;
  				$this->db->exec_query($sql);
  			}
  		}
  		if( !is_null($need_delete) ){
  			foreach($need_delete as $tcv_id){
  				$opt = 0;
  				switch( $suite ){
  					case 'affirm2':
  					case 'affirm3':
  						$sql =  " SELECT SU.name FROM nodes_hierarchy as TCV,nodes_hierarchy as TC,nodes_hierarchy as SU " .
  								" WHERE TCV.id={$tcv_id} AND TCV.parent_id=TC.id AND TC.parent_id=SU.id ";
  						$rs = $this->db->fetchFirstRow($sql);
  						if(($rs['name']=='确认测试2.0' && $suite=='affirm2')||($rs['name']=='确认测试3.0' && $suite=='affirm3')){
  							$opt = 1;
  						}
  						break;
  								
  					case 'function':
  						$sql =  " SELECT PSU.name FROM nodes_hierarchy as TCV,nodes_hierarchy as TC,nodes_hierarchy as SU, nodes_hierarchy as PSU" .
  								" WHERE TCV.id={$tcv_id} AND TCV.parent_id=TC.id AND TC.parent_id=SU.id AND SU.parent_id=PSU.id ";
  						$rs = $this->db->fetchFirstRow($sql);
  						if($rs['name'] == '功能测试'){
  							$opt = 1;
  						}
  						break;
  					default :
  						break;
  				}
  				if( $opt == 1 ){
  					$sql =  " SELECT COUNT(*) as total FROM executions WHERE testplan_id={$tplan_id} AND platform_id={$device_id} AND tcversion_id={$tcv_id}" ;
  					$rs = $this->db->fetchFirstRow($sql);
  					if( $rs['total']==0 ){
  						$sql =  " DELETE FROM testplan_tcversions WHERE testplan_id={$tplan_id} AND platform_id={$device_id} AND tcversion_id={$tcv_id}" ;
  						$this->db->exec_query($sql);
  					}else{
  						$sql =  " UPDATE testplan_tcversions SET active=0 WHERE testplan_id={$tplan_id} AND platform_id={$device_id} AND tcversion_id={$tcv_id}" ;
  						$this->db->exec_query($sql);
  					}
  				}
  			}
  		}
		return 'OK';
	}
	return "ERROR: This Device DONOT defined " . $suite . ' VAR info!!';
  }
  
  public function getTplanTestCases($tplanid){ 
    $sql =  " SELECT platform_id FROM {$this->tables['testplan_platforms']} WHERE testplan_id ={$tplanid} ORDER BY platform_id ASC ";
    $devices = $this->db->get_recordset($sql);
    $returnrs = array();
    if( !is_null($devices) ){ 
      foreach($devices as $index=>$device){ 
        $sql =  " SELECT id,active,skip,tcversion_id,author_id as assignby,creation_ts as assigntime FROM testplan_tcversions WHERE testplan_id ={$tplanid} AND platform_id = {$device['platform_id']} ";
        $cases = $this->db->get_recordset($sql);
        $returnrs[$index] = array();
        if( !is_null($cases) ){
          foreach($cases as $testcase){
            $temp['assigntime'] = $testcase['assigntime'];
            $temp['tcvid'] =  $testcase['tcversion_id'];
            $temp['active'] = $testcase['active'];
            $temp['skip'] =  $testcase['skip'];
            $temp['tptcid'] = $testcase['id'];
            $temp['executed'] = '0' ;
            $sql =  " SELECT id FROM executions WHERE testplan_id ={$tplanid} AND platform_id = {$device['platform_id']} AND tcversion_id = {$testcase['tcversion_id']} ";
            $exe = $this->db->get_recordset($sql);
            if( !is_null($exe) ){
                 $temp['executed'] = '1' ;
            }
            $sql =  " SELECT parent_id FROM nodes_hierarchy WHERE id={$testcase['tcversion_id']} " ;
            $rs = $this->db->fetchFirstRow($sql);
            $testcase_id = $rs['parent_id'];
            $temp['id'] = $rs['parent_id'];

            //test case name
            $sql =  " SELECT parent_id,name FROM nodes_hierarchy WHERE id={$testcase_id} " ;
            $rs = $this->db->fetchFirstRow($sql);
            $temp['name'] = $rs['name'];

            //test suite name and id
            $sql =  " SELECT name FROM nodes_hierarchy WHERE id={$rs['parent_id']} " ;
            $suiteid = $rs['parent_id'];
            $rs = $this->db->fetchFirstRow($sql);
            $temp['suite'] = $rs['name'];

            //script name
            $sql =  " SELECT preconditions,summary FROM tcversions WHERE id= {$testcase['tcversion_id']} " ;
            $rs = $this->db->fetchFirstRow($sql);
            $temp['script'] = $rs['preconditions'];
            $temp['summary'] = $rs['summary'];

            //user name
            $sql =  " SELECT login FROM users WHERE id= {$testcase['assignby']} " ;
            $rs = $this->db->fetchFirstRow($sql);
            $temp['assignby'] = $rs['login'];
            
            if( empty($returnrs[$index][$suiteid]) ){
            	$returnrs[$index][$suiteid] = array();
            }
            array_push($returnrs[$index][$suiteid], $temp);
          }
        }
      }
   }
   return $returnrs;
  }

  public function getTplanDeviceCases($tplanid,$deviceid,$suitename)
  { 
      $sql =  " SELECT tcversion_id FROM testplan_tcversions WHERE testplan_id ={$tplanid} AND platform_id = {$deviceid} ";
      $cases = $this->db->get_recordset($sql);
      $allcase = $noruncase = array();
      if( !is_null($cases) ){
          foreach($cases as $testcase){
               $sql =  " SELECT parent_id as tc_id FROM nodes_hierarchy WHERE `id`= {$testcase['tcversion_id']} " ;
               $rs = $this->db->fetchFirstRow($sql);
               //test case
               $sql =  " SELECT name,parent_id FROM nodes_hierarchy WHERE `id`= {$rs['tc_id']} " ;
               $case = $this->db->fetchFirstRow($sql) ;
              //suite name
               $sql =  " SELECT name  FROM nodes_hierarchy WHERE `id`= {$case['parent_id']} " ;
               $suite = $this->db->fetchFirstRow($sql);
              
               if( $suite['name'] == $suitename ){
                    $allcase[] = $case['name'];
               
                    $sql =  " SELECT id FROM executions WHERE testplan_id ={$tplanid} AND platform_id = {$deviceid} AND tcversion_id = {$testcase['tcversion_id']} ";
                    $rs = $this->db->get_recordset($sql);
                    if( is_null($rs) ){
                        $noruncase[] = $case['name'];
                    }
               }
            }
       }
      return array($allcase, $noruncase) ;
  } 

  public function getTplanDeviceCaseScript($tplanid,$deviceid)
  {
  	$sql =  " SELECT TPTCV.tcversion_id,TCV.preconditions ".
  	        " FROM testplan_tcversions as TPTCV, tcversions as TCV " .
  	        " WHERE TPTCV.testplan_id ={$tplanid} AND TPTCV.platform_id = {$deviceid} AND TPTCV.tcversion_id=TCV.id ";
  	$cases = $this->db->get_recordset($sql);
  	$allcase = $noruncase = array();
  	if( !is_null($cases) ){
  		foreach($cases as $testcase){
  			$temp = str_replace("\\", "\\\\" ,$testcase['preconditions']) ;
  			$temp = str_replace(' ', '\\ ' ,$temp) ;
  			  			
  			$allcase[] = $temp;
  			
  			$sql =  " SELECT id FROM executions WHERE testplan_id={$tplanid} AND tcversion_id={$testcase['tcversion_id']} AND platform_id={$deviceid} " ;
  			$rs = $this->db->get_recordset($sql);

  			if( $rs == null ){
 				$noruncase[] = $temp;
  			}
  		}
  	}
  	return array($allcase, $noruncase) ;
  }
  
  public function updateJobInfo($jobid,$status,$case)
  { 
    if( $status == 2 ){ //执行完毕 提交任务
    	if( preg_match("/^cloud(.*?)/i" , $jobid , $tempa) ){//云执行任务
        	$sql =  " UPDATE run_cloud_jobs SET status='complete' WHERE job_id = '{$jobid}' " ;
        	$this->db->exec_query($sql);
        	//清理环境
        	$client = new GearmanClient();
        	$client->addServer("localhost",4730);
        	$client->doBackground("killEnv_{$jobid}",$jobid);
    	}else{//传统任务
    		$sql = " SELECT * FROM running_jobs WHERE job_id='{$jobid}'";
    		$job = $this->db->fetchFirstRow($sql);
        	$sql =  " INSERT INTO run_end_jobs " . 
               		" (job_id,  job_type, topo_type, job_startTime,  productline_id,  tplan_id,  build_id,  device_id,  total_case,  pass_case, olddiff_case, fail_case,  accept_case,  block_case,  na_case,  skip_case,  warn_case,  user_id,  running_vdi, runend_case) " .
              		" VALUES ('{$job['job_id']}','{$job['job_type']}',{$job['topo_type']},'{$job['job_startTime']}','{$job['productline_id']}','{$job['tplan_id']}','{$job['build_id']}','{$job['device_id']}','{$job['total_case']}','{$job['pass_case']}','{$job['olddiff_case']}','{$job['fail_case']}','{$job['accept_case']}','{$job['block_case']}','{$job['na_case']}','{$job['skip_case']}','{$job['warn_case']}','{$job['user_id']}','{$job['running_vdi']}','{$job['runend_case']}' ) " ;
          	$this->db->exec_query($sql);

          	$sql =  " DELETE FROM running_jobs WHERE job_id = '{$job['job_id']}' " ;
          	$this->db->exec_query($sql);
        }
        return 'commit job success!';
    }else{ // 刷新任务暂停、继续或刷新任务当前case
    	if( preg_match("/^cloud(.*?)/i" , $jobid , $tempa) ){// 云执行任务
    		if( $status == 0 ){
    			$status = 'pause';
    		}elseif( $status == 1 ){
    			$status = 'running';
    		}
    		$sql =  " UPDATE run_cloud_jobs SET status = '{$status}' WHERE job_id = '{$jobid}' " ;
    		$rs = $this->db->exec_query($sql);
    		return $rs ? 'updateJobInfo success' : 'DB ERROR' ;
    	}else{ //传统任务
        	$run_time = "'" . date("H:i:s") . "'";
        	$sql =  " UPDATE running_jobs SET status = {$status} " ;
        	if($case != ''){
        		$sql = $sql . ", run_time = {$run_time}, running_case = '{$case}'" ;
      		}
      		$sql = $sql . " WHERE job_id = '{$jobid}' " ;
      		$rs = $this->db->exec_query($sql);
    		return $rs ? 'updateJobInfo success' : 'DB ERROR' ;
    	}
  	}
  }

  public function returnCreatedEnvDetails($jobid,$details)
  {
  	$sql =  " UPDATE run_cloud_jobs SET env_details = '{$details}'  WHERE job_id = '{$jobid}' " ;
  	$rs = $this->db->exec_query($sql);
  	return $rs ? 'returnCreatedEnvDetails Success' : 'DB ERROR' ;
  }
  
  public function updateJobBuild($jobid,$id)
  {
  	if( preg_match("/^cloud(.*?)/i" , $jobid , $tempa) ){
  		$sql =  " UPDATE run_cloud_jobs SET build_id = {$id}  WHERE job_id = '{$jobid}' " ;
  	}else{
  		$sql =  " UPDATE running_jobs SET build_id = {$id}  WHERE job_id = '{$jobid}' " ;
  	}
  	$rs = $this->db->exec_query($sql);
    return $rs ? 'updateJobBuild Success' : 'DB ERROR' ;
  }

  public function reportJobWorker($jobid,$ip)
  {
  	$cur_time = "'" . date("Y-m-d H:i:s") . "'";
  	$sql =  " UPDATE run_cloud_jobs SET worker='{$ip}',start_time ={$cur_time}  WHERE job_id='{$jobid}' " ;
  	$rs = $this->db->exec_query($sql);
  	return $rs ? 'reportJobWorker Success' : 'DB ERROR' ;
  }
  
  public function reportJobResult($jobid,$exeid)
  { 
    $sql = " SELECT status,tcversion_id FROM executions WHERE id={$exeid} ";
    $exe = $this->db->fetchFirstRow($sql);
    $result = $exe['status'] ;
    
    if( $result == 'x' ){ //na
         $sql = " UPDATE executions SET fail_type='x' WHERE id = {$exeid} ";
         $this->db->exec_query($sql);
    }elseif( $result == 'c' ){ //accept
         $sql = " UPDATE executions SET fail_type='a' WHERE id = {$exeid} ";
         $this->db->exec_query($sql);
    }elseif( $result == 'o' ){ //the old product/version diff
         $sql = " UPDATE executions SET fail_type='p' WHERE id = {$exeid} ";
         $this->db->exec_query($sql);
    }else{
         $sql = " UPDATE executions SET fail_type='none'  WHERE id = {$exeid} ";
         $this->db->exec_query($sql);
    }

    $sql = " SELECT parent_id as tcid FROM nodes_hierarchy WHERE id = {$exe['tcversion_id']} ";
    $rs = $this->db->fetchFirstRow($sql);

    $sql = " SELECT name FROM nodes_hierarchy WHERE id = {$rs['tcid']} ";
    $rs = $this->db->fetchFirstRow($sql);
    $testcase = $rs['name'] ;

    $sql = " UPDATE job_testcase SET result='{$result}',exe_id = {$exeid} ";
    switch ( $result ){
         case 'x' ://na
              $sql = $sql . " , fail_type = 'x'   " ;
              break;
         case 'c' ://accept
              $sql = $sql . " , fail_type = 'a'   " ;
              break ;
         case 'o' ://the old product/version diff
              $sql = $sql . " , fail_type = 'p'   " ;
              break ;
         default://default
              $sql = $sql . " , fail_type = 'none'  " ;
              break ;
      }
    $sql1 = $sql  .  " WHERE job_id = '{$jobid}' AND testcase='{$testcase}' " ;
    $this->db->exec_query($sql1);

    $tcversion_id = $exe['tcversion_id'] ;
    $sql2 = $sql  .  " WHERE job_id = '{$jobid}' AND testcase='{$tcversion_id}' " ;
    $this->db->exec_query($sql2);

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='p' " ;//pass
    $pass_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='f' " ;//fail
    $fail_case  = $this->db->fetchFirstRow($sql); 
    
    $sql = " SELECT count(*) as total FROM job_testcase WHERE  job_id = '{$jobid}' AND result='b' " ;//block
    $block_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='w' " ;//warn
    $warn_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE  job_id = '{$jobid}' AND result='x' " ;//na
    $na_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='s' " ;//skip
    $skip_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='c' " ;//accept
    $accept_case  = $this->db->fetchFirstRow($sql); 

    $sql = " SELECT count(*) as total FROM job_testcase WHERE job_id = '{$jobid}' AND result='o' " ;//olddiff
    $olddiff_case  = $this->db->fetchFirstRow($sql);
        
    $runend_case = $pass_case['total'] + $olddiff_case['total'] + $fail_case['total'] +  $block_case['total'] +  $waen_case['total'] +  $na_case['total'] +  $skip_case['total'] +  $accept_case['total']  ; 

    $sql = " UPDATE running_jobs SET pass_case={$pass_case['total']},olddiff_case={$olddiff_case['total']},fail_case={$fail_case['total']},accept_case={$accept_case['total']},block_case={$block_case['total']},na_case={$na_case['total']},skip_case={$skip_case['total']},warn_case={$warn_case['total']},runend_case={$runend_case} WHERE job_id = '{$jobid}' ";
    $rs = $this->db->exec_query($sql);

    if( $runend_case != 0 &&  $rs ){
               return 'reportJobResult Success';
       }else{
               return 'DB ERROR' ;
       }
  }

  public function getByName($name)
  {
    $val = trim($name);
    $sql =  " SELECT id, name, notes " .
            " FROM {$this->tables['platforms']} " .
            " WHERE name = '" . $this->db->prepare_string($val) . "'" .
            " AND testproject_id = " . intval($this->tproject_id);
    $ret = $this->db->fetchFirstRow($sql);
    return is_array($ret) ? $ret : null;  
  }
  
  /**
   * Gets all info of a platform
   * @return array with keys id, name and notes
     * @TODO remove - francisco
   */
    public function getPlatform($id)
    {
      return $this->getByID($id);
    }

    public function getIssue($id)
    {
      return $this->getIssueByID($id);
    }
	
  /**
   * Updates values of a platform in database.
   * @param $id the id of the platform to update
   * @param $name the new name to be set
   * @param $notes new notes to be set
   *
   * @return tl::OK on success, otherwise E_DBERROR
   */
  public function update($id, $name, $supportl3, $isboxswitch, $linespeed,$affirm2devicegroup,$affirm3devicegroup,$functiondevicegroup,$performance_id, $notes)
  {
    $safeName = $this->throwIfEmptyName($name);
    $sql = " UPDATE {$this->tables['platforms']} " .
           " SET name = '" . $this->db->prepare_string($name) . "' " .
           ", notes =  '". $this->db->prepare_string($notes) . "' " .
		   ", supportl3 =  '". $supportl3 . "' " .
		   ", isboxswitch =  '". $isboxswitch . "' " .
		   ", linespeed =  '". $linespeed . "' " .
		   ", affirm2_var =  '". $affirm2devicegroup . "' " .
		   ", affirm3_var =  '". $affirm3devicegroup . "' " .
		   ", function_var =  '". $functiondevicegroup . "' " .
		   ", performance_id =  '". $performance_id . "' " .
		   
         " WHERE id = {$id}";
    $result =  $this->db->exec_query($sql);
    return $result ? tl::OK : self::E_DBERROR;
  }

  public function updateIssue($issue_id,$testcase,$step,$product,$script,$comment)
  {
    $sql = " UPDATE acceptablebugs " .
           " SET testcase = '$testcase' " .
           ", failedsteps = '$step' " .
		   ", product = '$product' " .
		   ", script_version = '$script' " .
		   ", comment = '$comment' " .
           " WHERE id = {$issue_id}";
    $result =  $this->db->exec_query($sql);
    return $result ? tl::OK : self::E_DBERROR;
  }
  
  /**
   * Removes a platform from the database.
   * @TODO: remove all related data to this platform?
   *        YES!
   * @param $id the platform_id to delete
   *
   * @return tl::OK on success, otherwise E_DBERROR
   */
  public function delete($id)
  {
    $sql = "DELETE FROM {$this->tables['platforms']} WHERE id = {$id}";
    $result = $this->db->exec_query($sql);
    
    return $result ? tl::OK : self::E_DBERROR;
  }
  
  public function deleteIssue($id)
  {
    $sql = "DELETE FROM acceptablebugs WHERE id = {$id}";
    $result = $this->db->exec_query($sql);
    
    return $result ? tl::OK : self::E_DBERROR;
  }
  /**
   * links one or more platforms to a testplan
   *
   * @return tl::OK if successfull otherwise E_DBERROR
   */
  public function linkToTestplan($id, $testplan_id)
  {
    $result = true;
    if( !is_null($id) )
    {
      $idSet = (array)$id;
      foreach ($idSet as $platform_id)
      {
        $sql = " INSERT INTO {$this->tables['testplan_platforms']} " .
            " (testplan_id, platform_id) " .
            " VALUES ($testplan_id, $platform_id)";
        $result = $this->db->exec_query($sql);
        if(!$result)
        {
          break;
        }  
      }
    }
    return $result ? tl::OK : self::E_DBERROR;
  }

  /**
   * Removes one or more platforms from a testplan
   * @TODO: should this also remove testcases and executions?
   *
   * @return tl::OK if successfull otherwise E_DBERROR
   */
  public function unlinkFromTestplan($id,$testplan_id)
  {
    $result = true;
    if( !is_null($id) )
    {
      $idSet = (array)$id;
      foreach ($idSet as $platform_id)
      {
        $sql = " DELETE FROM {$this->tables['testplan_platforms']} " .
             " WHERE testplan_id = {$testplan_id} " .
             " AND platform_id = {$platform_id} ";
          
          $result = $this->db->exec_query($sql);
        if(!$result)
        {
          break;
        }  
      }     
    }
    return $result ? tl::OK : self::E_DBERROR;
  }

  /**
   * Gets the id of a platform given by name
   *
   * @return integer platform_id
   */
  public function getID($name)
  {
    $sql = " SELECT id FROM {$this->tables['platforms']} " .
         " WHERE name = '" . $this->db->prepare_string($name) . "'" .
         " AND testproject_id = {$this->tproject_id} ";
    return $this->db->fetchOneValue($sql);
  }

  public function getAllPerformance()
  {
  	$sql = " SELECT * FROM var_performance WHERE testproject_id = {$this->tproject_id} ";
  	return $this->db->get_recordset($sql);
  }
  
  /**
   * get all available platforms on active test project
   *
   * @options array $options Optional params
   *                         ['include_linked_count'] => adds the number of
   *                         testplans this platform is used in
   *                         
   * @return array 
   *
   * @internal revisions
   */
  public function getAll($options = null)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $default = array('include_linked_count' => false);
    $options = array_merge($default, (array)$options);
    
    $tproject_filter = " WHERE PLAT.testproject_id = {$this->tproject_id} ";
    
    $sql =  " SELECT PLAT.id, PLAT.name, PLAT.supportl3, PLAT.isboxswitch, PLAT.linespeed, PLAT.notes, " . 
            " PLAT.affirm2_var,PLAT.affirm3_var,PLAT.function_var, PLAT.performance_id,P.name as performance_name," . 
            " VA.name as affirm2_var_name, VB.name as affirm3_var_name, VC.name as function_var_name " .
            " FROM platforms as PLAT " .
            " LEFT JOIN var_performance as P ON PLAT.performance_id=P.id " .
            " LEFT JOIN vars as VA ON PLAT.affirm2_var=VA.id " .
            " LEFT JOIN vars as VB ON PLAT.affirm3_var=VB.id " .
            " LEFT JOIN vars as VC ON PLAT.function_var=VC.id " .
 			" $tproject_filter ORDER BY PLAT.name";
    $rs = $this->db->get_recordset($sql);
    if( !is_null($rs) && $options['include_linked_count'])
    {
      // At least on MS SQL Server 2005 you can not do GROUP BY fields of type TEXT
      // notes is a TEXT field
      // $sql =  " SELECT PLAT.id,PLAT.name,PLAT.notes, " .
      //     " COUNT(TPLAT.testplan_id) AS linked_count " .
      //     " FROM {$this->tables['platforms']} PLAT " .
      //     " LEFT JOIN {$this->tables['testplan_platforms']} TPLAT " .
      //     " ON TPLAT.platform_id = PLAT.id " . $tproject_filter .
      //     " GROUP BY PLAT.id, PLAT.name, PLAT.notes";
      
      $sql =  " SELECT PLAT.id, COUNT(TPLAT.testplan_id) AS linked_count " .
          " FROM {$this->tables['platforms']} PLAT " .
          " LEFT JOIN {$this->tables['testplan_platforms']} TPLAT " .
          " ON TPLAT.platform_id = PLAT.id " . $tproject_filter .
          " GROUP BY PLAT.id ";
      $figures = $this->db->fetchRowsIntoMap($sql,'id');   
      
      $loop2do = count($rs);
      for($idx=0; $idx < $loop2do; $idx++)
      {
        $rs[$idx]['linked_count'] = $figures[$rs[$idx]['id']]['linked_count'];        
      }          
    }
    
    return $rs;
  }

  public function getAllVars(){
  	$sql = " SELECT id as '0',suite_id as '1',name as '2' FROM vars WHERE project_id={$this->tproject_id} AND name != 'undefined' ORDER BY name ASC " ;
  	return $this->db->get_recordset($sql);
  }

  public function getAllSuites(){
  	$returnrs = array();
   /*	$sql = " SELECT TSU.id,TSU.name FROM nodes_hierarchy as TSU,nodes_hierarchy as TCV " .
           " WHERE TCV.parent_id=TSU.id AND TCV.node_type_id=3 GROUP BY TSU.id " ;
  	$suites = $this->db->get_recordset($sql);
    $returnrs = array();

  	foreach($suites as $suite){
  	  	$rs = array('id'=>$suite['id'],'node_type_id'=>0);		    
  		while($rs['node_type_id'] != 1){
  		    $temp = " SELECT NHP.id,NHP.node_type_id FROM nodes_hierarchy as NH,nodes_hierarchy as NHP WHERE NH.parent_id = NHP.id AND NH.id={$rs['id']} ";  		    	
  		  	$rs = $this->db->fetchFirstRow($temp);
  		}
  		if( $rs['id'] == $this->tproject_id){ //排除 产品线
  		   	array_push($returnrs,$suite);
  		}
  		*/
  		
  	if($this->tproject_id == 1){//switch
  		$returnrs = array(array('id'=>3959,'name'=>'确认测试2.0'),array('id'=>4944,'name'=>'确认测试3.0'),array('id'=>67,'name'=>'功能测试'));	
  	}
  	return $returnrs;
  }
  
  public function getVarTcversions($suite_id,$var_id){
  	$sql = " SELECT TCV.id,TCV.preconditions as name,TCV.summary,U.login as user,VT.modify_ts as time,VT.rdm " .
    	   " FROM tcversions as TCV,var_tcversions as VT,users as U " .
    	   " WHERE VT.var_id={$var_id} AND TCV.id=VT.tcversion_id AND U.id=VT.user_id " ;
  	$varcase = $this->db->fetchRowsIntoMap($sql,'id');
  	switch($suite_id){
  		case 3959: //affirm2
  		case 4944://affirm3
  			$sql = " SELECT id,name FROM nodes_hierarchy WHERE parent_id={$suite_id} AND node_type_id=3 " ;
  			$allcase = $this->db->fetchRowsIntoMap($sql,'id');
  			$allcase_key = array_keys($allcase);
  			break;
  		case 666://function
  			break;
  	}
  	$varcase_key = array_keys($varcase);
  	$not_in_key = array_diff($allcase_key,$varcase_key);
  	return array('all'=>$allcase,'var'=>$varcase,'not_in_id'=>$not_in_key);
  }
  
  public function getVarTcversions_forexport($suite_id,$var_id){
  	switch($suite_id){
  		case 3959: //affirm2
  		case 4944://affirm3
  			$sql = " SELECT id,name FROM nodes_hierarchy WHERE parent_id={$suite_id} AND node_type_id=3 " ;
  			$rs = $this->db->fetchRowsIntoMap($sql,'id');
  			$temp = array_keys($rs);
  			
  			break;

  			
  			break;
  		case 666://function
  			break;
  	}
  	
  	$sql = " SELECT TCV.preconditions as name " .
  			" FROM tcversions as TCV,var_tcversions as VT,users as U " .
  			" WHERE VT.var_id={$var_id} AND TCV.id=VT.tcversion_id AND U.id=VT.user_id " ;
  	return $this->db->get_recordset($sql);
  }
  
  public function deleteVarTcversion($varid,$script){
  	$sql = "SELECT id FROM tcversions WHERE preconditions='{$script}' ";
  	$rs = $this->db->fetchFirstRow($sql);
  	if( $rs != null ){
  		$sql = " DELETE FROM var_tcversions WHERE tcversion_id={$rs['id']} AND var_id={$varid} " ;
  		$this->db->exec_query($sql);
  	}
  }
  
  public function getTplanCasesScripts($tplan_id,$device_id){
  	$sql = " SELECT TPTCV.tcversion_id,TCV.preconditions as script " .
  	       " FROM testplan_tcversions as TPTCV,tcversions as TCV " .
  	       " WHERE TPTCV.testplan_id={$tplan_id} AND TPTCV.platform_id={$device_id} AND TPTCV.tcversion_id=TCV.id " ;
  	return $this->db->get_recordset($sql);
  }
  
  public function addVarTcversion($varid,$script,$user_name){
  	$sql = "SELECT id FROM users WHERE login='{$user_name}' ";
  	$userid = $this->db->fetchFirstRow($sql);
  	
  	$sql = "SELECT id FROM tcversions WHERE preconditions='{$script}' ";
  	$tcversion = $this->db->fetchFirstRow($sql);
  	if( $tcversion != null ){
  		$sql = " SELECT * FROM var_tcversions WHERE tcversion_id={$tcversion['id']} AND var_id={$varid} " ;
  		$rs = $this->db->fetchFirstRow($sql);
  		if( $rs != null ){ 
  			return '该测试例已经存在于该分支中，请仔细检查!';
  		}else{
  			$sql = " INSERT INTO var_tcversions (tcversion_id,var_id,user_id) VALUES ({$tcversion['id']},{$varid},{$userid['id']}) " ;
  			$this->db->exec_query($sql);
  			return '添加成功!';
  		}
  	}else{
  		return '测试例在testlink中不存在，请前往"用例管理"模块确认!';  		
  	}
  }
  
  public function addNewVar($suiteid,$var_name){
  	$sql = " SELECT id FROM vars WHERE suite_id={$suiteid} AND name='{$var_name}' ";
  	$rs = $this->db->fetchFirstRow($sql);
  	
  	$returnrs = 0;
  	if ( $rs == null ){
  		$sql = " SELECT project_id FROM vars WHERE suite_id={$suiteid} ";
  		$rs = $this->db->fetchFirstRow($sql);
  		$sql = " INSERT INTO vars (project_id,suite_id,name) VALUES ({$rs['project_id']},{$suiteid},'{$var_name}') " ;
  		$this->db->exec_query($sql);
  		$returnrs = 1;
  	}
  	return $returnrs;
  }
  
  public function getVarCases($var_id){
  	$sql = " SELECT tcversion_id FROM var_tcversions WHERE var_id={$var_id} " ;
    $cases = $this->db->get_recordset($sql);
    $returnrs = array();
    foreach($cases as $case){
    	$returnrs[] = $case['tcversion_id'];
    }
    return $returnrs;
  }
  
  public function getTcversionName($tcv_id){
  	$sql = " SELECT TC.name FROM nodes_hierarchy as TC,nodes_hierarchy as TCV " . 
  	       " WHERE TCV.parent_id=TC.id AND TCV.id={$tcv_id} " ;
  	$rs = $this->db->fetchFirstRow($sql);
  	return $rs['name'];
  }
  
  public function getVarDevices($var_id,$suite_id){
  	switch($suite_id){
  		case 3959: //affirm2
  			$sql = " SELECT id,name FROM platforms WHERE affirm2_var={$var_id} " ;
  			break;
  		case 4944: //affirm3
  	        $sql = " SELECT id,name FROM platforms WHERE affirm3_var={$var_id} " ;
  			break;
  		case 67: //function
  	        $sql = " SELECT id,name FROM platforms WHERE function_var={$var_id} " ;
  			break;
  		default:
  			break;
  	}
  	$devices = $this->db->get_recordset($sql);
  	$rs = array(0=>array(),'all'=>'');
  	$rs[0] = $devices;
  	foreach($devices as $device){
  		$rs['all'] = $rs['all'] . $device['name'] . ';' ;
  	}
  	return $rs;
  }
 
  public function getDeviceTplan($device_id,$allplan){
  	$sql = " SELECT TPD.testplan_id as id,TP.name FROM testplan_platforms as TPD,nodes_hierarchy as TP " .
  	       " WHERE TP.id=TPD.testplan_id AND TPD.platform_id={$device_id} " ;
  	if( $allplan == 0 ){
  		$sql = $sql . " AND TP.name NOT LIKE '售后维护-%' " ;
  	}
  	$tplans = $this->db->get_recordset($sql);
  	$rs = array(0=>array(),'all'=>'');
  	$rs[0] = $tplans;
  	foreach($tplans as $tplan){
  		$rs['all'] = $rs['all'] . $tplan['name'] . ';' ;
  	}
  	return $rs;
  }
  
  public function modifyTplanCasesFromVar($tplan_id,$device_id,$var_id,$suite_id,$user,$opt){
  	$sql = " SELECT id FROM users WHERE login='{$user}' ";
  	$rs = $this->db->fetchFirstRow($sql);
  	$user_id = $rs['id'];
	switch($suite_id){
  		case 3959://affirm2
  		case 4944://affirm3
  	        $sql = " SELECT TPTCV.tcversion_id " .
  	        	   " FROM testplan_tcversions as TPTCV,nodes_hierarchy as TCV,nodes_hierarchy as TC " .
    	           " WHERE TPTCV.active=1 AND TPTCV.testplan_id={$tplan_id} AND TPTCV.platform_id={$device_id} AND TPTCV.tcversion_id=TCV.id AND TCV.parent_id=TC.id AND TC.parent_id={$suite_id}" ;
            $rs = $this->db->fetchRowsIntoMap($sql,'tcversion_id');
  			break;
  		case 67://function
  			$sql = " SELECT TPTCV.tcversion_id " .
  			       " FROM testplan_tcversions as TPTCV,nodes_hierarchy as TCV,nodes_hierarchy as TC,nodes_hierarchy as SU " .
  				   " WHERE TPTCV.active=1 AND TPTCV.testplan_id={$tplan_id} AND TPTCV.platform_id={$device_id} AND TPTCV.tcversion_id=TCV.id AND TCV.parent_id=TC.id AND TC.parent_id=SU.id AND SU.parent_id={$suite_id}" ;
  			$rs = $this->db->fetchRowsIntoMap($sql,'tcversion_id');
  			break;
  		default:
  			break;
  	}
  	$old_tcvs = array_keys($rs);
  	if(is_null($old_tcvs)){   $old_tcvs = array();  	}

  	$sql = " SELECT tcversion_id FROM var_tcversions WHERE var_id={$var_id} ";
  	$rs = $this->db->fetchRowsIntoMap($sql,'tcversion_id');
  	$new_tcvs = array_keys($rs); 
  	if(is_null($new_tcvs)){   $new_tcvs = array();  	}

  	$needadd = array_diff($new_tcvs,$old_tcvs);
  	$needdelete = array_diff($old_tcvs,$new_tcvs);
  	if(!is_null($needadd) & $opt == 'add' ){
  		foreach($needadd as $tcv){
  			$sql = " SELECT id FROM testplan_tcversions WHERE testplan_id={$tplan_id} AND tcversion_id={$tcv} AND platform_id={$device_id} " ;
  			$rs = $this->db->get_recordset($sql);
  			if( is_null($rs) ){
  				$sql = " INSERT INTO testplan_tcversions (testplan_id,tcversion_id,platform_id,author_id) " .
  			    	   " VALUES ({$tplan_id},{$tcv},{$device_id},{$user_id}) ";			
  			}else{
  				$sql = " UPDATE testplan_tcversions set active=1,author_id={$user_id} WHERE id={$rs[0]['id']} ";  				
  			}
  			$this->db->exec_query($sql);
  		}
  		return $needdelete;
  	}
  	if(!is_null($needdelete) & $opt=='delete'){
  		foreach($needdelete as $tcv){
  			$sql = " SELECT count(id) as num FROM executions WHERE testplan_id={$tplan_id} AND tcversion_id={$tcv} AND platform_id={$device_id} ";
  			$rs = $this->db->fetchFirstRow($sql);
  			if( $rs['num'] == 0 ){
  				$sql = " DELETE FROM testplan_tcversions WHERE testplan_id={$tplan_id} AND tcversion_id={$tcv} AND platform_id={$device_id} ";
  			}else{
  				$sql = " UPDATE testplan_tcversions SET active=0 " .
  					   " WHERE testplan_id={$tplan_id} AND tcversion_id={$tcv} AND platform_id={$device_id} ";
  			}
  			$this->db->exec_query($sql);
  		}
  		return ture;
  	}
  }
  
  public function modifyVarCases($var_id, $tcversion_id, $login_username,$opt){
  	$sql = " SELECT id FROM users WHERE login='{$login_username}' " ;
  	$user = $this->db->fetchFirstRow($sql);
  	$user_id = $user['id'];
    switch($opt){
    	case 'add':
    		$sql = " INSERT INTO var_tcversions (var_id,tcversion_id,user_id) " . 
    		       " VALUES ($var_id, $tcversion_id,$user_id) "; 
    		break;
    	case 'delete':
    		$sql = " DELETE FROM var_tcversions WHERE var_id={$var_id} AND tcversion_id={$tcversion_id} ";
    		break;
    	default:
    		break;
    }
    $this->db->exec_query($sql);
  }
  
  public function getCaseNamebyTCVid($tcvid){
  	$sql = " SELECT TC.name FROM nodes_hierarchy as TC, nodes_hierarchy as TCV " .
  		   " WHERE TCV.parent_id=TC.id  AND TCV.id={$tcvid} " ;
  	$tc = $this->db->fetchFirstRow($sql);
  	return $tc['name'];
  }
  
  public function getTcversionidByName($case_name,$suite){
  	$sql = " SELECT SU.name,TCV.id" . 
  	       " FROM nodes_hierarchy as SU,nodes_hierarchy as TC,nodes_hierarchy as TCV" . 
  	       " WHERE SU.id=TC.parent_id AND TC.id=TCV.parent_id AND TC.name='{$case_name}' " ;
  	$sus = $this->db->get_recordset($sql);
  	$rs = 0;
  	foreach($sus as $su){
        switch($suite){
    	    case 'affirm2':
    		    if($su['name']=='确认测试2.0'){
    			    $rs = $su['id'];
    		    }
    		    break;
    	    case 'affirm3':
    		    if($su['name']=='确认测试3.0'){
    			    $rs = $su['id'];
    		    }
    		    break;
    	    default:
    	        if($su['name'] == $suite){
    			    $rs = $su['id'];
    		    }
    		    break;
        }
    }
    return $rs;
  }
    
  public function getMonthReport($mydate,$view_mode)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $start = date("Y-m", strtotime($mydate) );
    $end = date("Y-m", strtotime( "+1 months",strtotime($mydate) ) ) ;
    
    $filter = ''; 
    if($this->tproject_id == 1 ){
    	$filter = " AND J.job_type IN ('affirm2','affirm3','affirm3|affirm2','college','oversea','financial') ";
    }elseif($this->tproject_id == 2){
    	$filter = " AND J.job_type IN ('waffirm','waffirm_X86') " ;
    }
    
    $sql = "SELECT J.job_id,J.topo_type, U.login as user, J.tplan_id,TP.name as tplan_name,J.job_startTime, J.job_type,D.name as device,J.total_case,J.pass_case, J.fail_case,J.na_case,J.accept_case,J.block_case,J.warn_case,J.skip_case,J.runend_case " .
    	   " FROM run_end_jobs as J, users as U, platforms as D, nodes_hierarchy as TP" . 
           " WHERE J.job_startTime >= '{$start}-01 00:00:00' AND J.job_startTime <= '{$end}-01 00:00:00' AND U.id = J.user_id AND J.device_id=D.id AND J.status=1 AND TP.id=J.tplan_id {$filter} ORDER BY J.job_startTime DESC";
    $rs = $this->db->get_recordset($sql);

    $returnrs = array() ; 
    if( !is_null($rs) ){
    	if($view_mode == 0){
        	$returnrs['total']['user'] = ' 月度汇总' ;
        	$returnrs['total']['job_startTime'] = $mydate ;
        	$returnrs['total']['job_type'] = '自动测试' ;
        	$returnrs['total']['device'] = count($rs) . "设备(次)" ;
        	$returnrs['total']['total']=$returnrs['total']['runend']=$returnrs['total']['fail']= $returnrs['total']['switch'] =$returnrs['total']['accept']=$returnrs['total']['script']=$returnrs['total']['productdiff']=$returnrs['total']['versiondiff']=$returnrs['total']['checklist']=$returnrs['total']['environment']=$returnrs['total']['nomerge']=$returnrs['total']['na']=0;
        	foreach($rs as $job){
            	$temp['user'] = $job['user'] ;
            	$temp['tplan_name'] = $job['tplan_name'] ;
            	$temp['job_id'] = $job['job_id'] ;
             	$temp['topo_type'] = $job['topo_type'] ;
             	$temp['job_startTime'] = $job['job_startTime'] ;
             	$temp['job_type'] = $job['job_type'] ;
             	$temp['device'] = $job['device'] ;
             	$temp['total'] = $job['total_case'] ;
             	$temp['fail'] = $job['fail_case'] + $job['olddiff_case'] + $job['na_case'] + $job['accept_case'] + $job['block_case'] + $job['warn_case'] + $job['skip_case'] ;
             	$temp['runend'] = $job['pass_case'] + $temp['fail'] ;
             	$returnrs['total']['total'] += $temp['total'] ;
             	$returnrs['total']['fail'] += $temp['fail'] ;
             	$returnrs['total']['runend'] += $temp['runend'] ;

             	$jobid = $job['job_id'] ;
             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'f' ";
            	$rs = $this->db->fetchFirstRow($sql);
             	$temp['switch'] = $rs['total'];
             	$returnrs['total']['switch'] += $temp['switch'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'a' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['accept'] = $rs['total'];
             	$returnrs['total']['accept'] += $temp['accept'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 's' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['script'] = $rs['total'];
             	$returnrs['total']['script'] += $temp['script'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'p' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['productdiff'] = $rs['total'];
             	$returnrs['total']['productdiff'] += $temp['productdiff'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'v' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['versiondiff'] = $rs['total'];
             	$returnrs['total']['versiondiff'] += $temp['versiondiff'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'c' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['checklist'] = $rs['total'];
             	$returnrs['total']['checklist'] += $temp['checklist'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'e' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['environment'] = $rs['total']; 
             	$returnrs['total']['environment'] += $temp['environment'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'x' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['na'] = $rs['total'];
             	$returnrs['total']['na'] += $temp['na'] ;
             	
             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'm' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['nomerge'] = $rs['total'];
             	$returnrs['total']['nomerge'] += $temp['nomerge'] ;

             	$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'none' AND result != 'p' ";
            	$rs = $this->db->fetchFirstRow($sql);
             	$temp['none'] = $rs['total'];
             	$returnrs['total']['none'] += $temp['none'] ;

             	$sql = "SELECT count(*) as total FROM job_testcase WHERE job_id='{$jobid}' AND result = 'o' ";
             	$rs = $this->db->fetchFirstRow($sql);
             	$temp['olddiff'] = $rs['total'];
             	$returnrs['total']['olddiff'] += $temp['olddiff'] ;
             	             	
             	$returnrs[] = $temp ;
        	}
    	}elseif($view_mode == 1){
        	foreach($rs as $job){
        		$tplanid = $job['tplan_id'];
        		$jobid = $job['job_id'] ;
        		$temp['fail'] = $job['fail_case'] + $job['olddiff_case'] + $job['na_case'] + $job['accept_case'] + $job['block_case'] + $job['warn_case'] + $job['skip_case'] ;
        		$temp['runend'] = $job['pass_case'] + $temp['fail'] ;
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'f' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['switch'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'a' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['accept'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 's' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['script'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'p' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['productdiff'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'v' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['versiondiff'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'c' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['checklist'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'e' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['environment'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'x' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['na'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'm' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['nomerge'] = $rs['total'];
        		
        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND fail_type = 'none' AND result != 'p' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['none'] = $rs['total'];

        		$sql = "SELECT count(*) as total  FROM job_testcase WHERE job_id='{$jobid}' AND result = 'o' ";
        		$rs = $this->db->fetchFirstRow($sql);
        		$temp['olddiff'] = $rs['total'];
        		
        		if( !isset($returnrs[$tplanid]) ){
        			$returnrs[$tplanid]['tplan'] = $job['tplan_name'] ;
        		}
        		$returnrs[$tplanid]['runend'] += $temp['runend'] ;
        		$returnrs[$tplanid]['fail'] += $temp['fail'] ;
        		$returnrs[$tplanid]['switch'] += $temp['switch'] ;
        		$returnrs[$tplanid]['accept'] += $temp['accept'] ;
        		$returnrs[$tplanid]['script'] += $temp['script'] ;
        		$returnrs[$tplanid]['productdiff'] += $temp['productdiff'] ;
        		$returnrs[$tplanid]['versiondiff'] += $temp['versiondiff'] ;
        		$returnrs[$tplanid]['checklist'] += $temp['checklist'] ;
        		$returnrs[$tplanid]['environment'] += $temp['environment'] ;
        		$returnrs[$tplanid]['na'] += $temp['na'] ;
        		$returnrs[$tplanid]['none'] += $temp['none'] ;
        		$returnrs[$tplanid]['nomerge'] += $temp['nomerge'] ;
        		$returnrs[$tplanid]['olddiff'] += $temp['olddiff'] ;
        	}
    	}
    }
    return $returnrs ;
  }
  
  public function getMonthReportJob($id)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;

    $sql = "SELECT * FROM job_testcase WHERE job_id = '{$id}' ";
    $rs = $this->db->get_recordset($sql);
    $returnrs = array() ;
    if( !is_null($rs) ){
             foreach( $rs as $case){
              if( $case['result'] != 'p' ){
                $temp['exe_id']  = $case['exe_id'] ;
                $temp['testcase']  = $case['testcase'] ;
                 
                $sql = "SELECT parent_id FROM nodes_hierarchy WHERE id='{$case['testcase']}' ";
                $case_id = $this->db->fetchFirstRow($sql); 

                if( !is_null($case_id['parent_id'] )  ){
                    $sql = "SELECT name FROM nodes_hierarchy WHERE id='{$case_id['parent_id']}' ";
                    $rs = $this->db->fetchFirstRow($sql);
                    $temp['testcase'] = $rs['name'];
                }
                switch( $case['result']) {
                  case 'f' :
                     $temp['result'] = 'Fail' ;
                     break ;
                  case 'c' :
                     $temp['result'] = 'Accept' ;
                     break ;
                  case 'x' :
                     $temp['result'] = 'N/A' ;
                     break ;
                  case 's' :
                     $temp['result'] = 'Skip' ;
                     break ;
                  case 'b' :
                     $temp['result'] = 'Block' ;
                     break ;
                  case 'w' :
                     $temp['result'] = 'Warn' ;
                     break ;
                  case 'o' :
                     $temp['result'] = '差异未处理' ;
                     break ;
                }
                switch( $case['fail_type']) {
                  case 'f' :
                     $temp['fail_type'] = '交换机Bug' ;
                     break ;
                  case 'a' :
                     $temp['fail_type'] = '已知缺陷' ;
                     break ;
                  case 'm' :
                     $temp['fail_type'] = '售后未合入' ;
                     break ;
                  case 's' :
                     $temp['fail_type'] = '脚本问题' ;
                     break ;
                  case 'p' :
                     $temp['fail_type'] = '产品差异' ;
                     break ;
                  case 'v' :
                     $temp['fail_type'] = '版本差异' ;
                     break ;
                  case 'c' :
                     $temp['fail_type'] = '方案问题' ;
                     break ;
                  case 'e' :
                     $temp['fail_type'] = '环境问题' ;
                     break ;
                  case 'x' :
                     $temp['fail_type'] = '无效测试' ;
                     break ;
                  case 'none' :
                     $temp['fail_type'] = '未分析' ;
                     break ;
                  }
                  $temp['notes'] = '' ;
                  if( !is_null($case['exe_id']) ){
                     $sql = "SELECT notes FROM executions WHERE id = {$case['exe_id']} ";
                     $rs = $this->db->fetchFirstRow($sql);
                     $temp['notes'] = $rs['notes'];
                  }
              $returnrs[] = $temp ;
              }
        }
     return $returnrs ;
     }
 }

  public function getAllissue()
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $tproject_filter = " WHERE productline_id = {$this->tproject_id} ";
    
    $sql =  " SELECT id, product, script_version, testcase, failedsteps, comment FROM acceptablebugs {$tproject_filter} ";
    $rs = $this->db->get_recordset($sql);
    return $rs;
  }

  public function getJobTotalCase($tplan,$device,$suite,$platform)
  {
     //$sql =  " SELECT tcversion_id FROM testplan_tcversions WHERE testplan_id={$tplan} AND platform_id={$device} AND active=1 AND skip!=1 ";
     if($platform == 'moni'){
     	$sql = " SELECT TPTCV.tcversion_id FROM testplan_tcversions as TPTCV,tcversions as TCV " .
     		   " WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id={$tplan} AND TPTCV.platform_id={$device} AND TPTCV.active=1 AND TPTCV.skip!=1 AND TCV.preconditions LIKE '%.tcl' ";
     }elseif($platform == 'dauto'){
     	$sql = " SELECT TPTCV.tcversion_id FROM testplan_tcversions as TPTCV,tcversions as TCV " .
     		   " WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id={$tplan} AND TPTCV.platform_id={$device} AND TPTCV.active=1 AND TPTCV.skip!=1 AND TCV.preconditions LIKE '%.py' ";
     }else{
     	$sql =  " SELECT tcversion_id FROM testplan_tcversions WHERE testplan_id={$tplan} AND platform_id={$device} AND active=1 AND skip!=1 ";
     }     
     
     $cases = $this->db->get_recordset($sql);
     $total = 0;
     
     foreach($cases as $testcase){
            $sql =  " SELECT parent_id FROM nodes_hierarchy WHERE `id`= {$testcase['tcversion_id']} " ;
            $rs = $this->db->fetchFirstRow($sql);     
            $sql =  " SELECT parent_id FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
            $rs = $this->db->fetchFirstRow($sql);
            $sql =  " SELECT name FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
            $rs = $this->db->fetchFirstRow($sql);

            if($suite=='affirm3|affirm2'){
            	if($rs['name'] == '确认测试3.0'){  ++$total;  }
            	if($rs['name'] == '确认测试2.0'){  ++$total;  }
            }else{
            	if($rs['name'] == $suite){
            		++$total;
            	}
            }
     }
   return $total;
  }

  public function getAllRunningjobs()
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;

    $tproject_filter = " WHERE productline_id = {$this->tproject_id} ";
    
    $sql =  " SELECT * FROM running_jobs {$tproject_filter} ORDER BY job_startTime DESC";
    $temp = $this->db->get_recordset($sql);
    foreach($temp as $job){
          //get test plan name
          $tempsql = "/* $debugMsg */ SELECT name " .
                     " FROM {$this->tables['nodes_hierarchy']} " .
                     " WHERE  node_type_id = 5 and id = {$job['tplan_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['tplan'] = $exec[0]['name'];
          }else{$myjob['tplan'] = '已删除';}  
        
          //get build name
          $tempsql = "/* $debugMsg */ SELECT name " .
                     " FROM {$this->tables['builds']} " .
                     " WHERE  testplan_id = {$job['tplan_id']} and id = {$job['build_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['build'] = $exec[0]['name'];
          }else{$myjob['build'] = '已删除';}
          //get device name
          $tempsql = "/* $debugMsg */ SELECT name " .
                     " FROM {$this->tables['platforms']} " .
                     " WHERE  id = {$job['device_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['device'] = $exec[0]['name'];
          }else{$myjob['device'] = '已删除';}
          //get user name
          $tempsql = "/* $debugMsg */ SELECT login " .
                     " FROM {$this->tables['users']} " .
                     " WHERE  id = {$job['user_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['user'] = $exec[0]['login'];
          }else{$myjob['user'] = '不存在';}
          
          $myjob['process'] = round($job['runend_case']*100/$job['total_case'],2) . '%';
          $myjob['job_id'] = $job['job_id'];
          $myjob['job_startTime'] = $job['job_startTime'];
          $myjob['total_case'] = $job['total_case'];
          $myjob['runend_case'] = $job['runend_case'];
          $myjob['running_case'] = $job['running_case'];
          $myjob['running_vdi'] = $job['running_vdi'];
          $myjob['status'] = $job['status'];
          $myjob['run_time'] = $job['run_time'];
          $myjob['jobtype'] = $job['job_type'];
          $myjob['topo_type'] = $job['topo_type'];
          $jobs[] = $myjob;
    }
    return $jobs;
  }

  public function getAllRunendjobs($start,$end)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $tproject_filter = " AND productline_id = {$this->tproject_id} ";
    
    $sql =  " SELECT * FROM run_end_jobs WHERE job_endTime>='{$start}-01 00:00:00' AND job_endTime<='{$end}-31 24:59:59' {$tproject_filter} ORDER BY job_endTime DESC";

    $temp = $this->db->get_recordset($sql);
    foreach($temp as $job){
         //get test plan name
         $tempsql = "/* $debugMsg */ SELECT name " .
                    " FROM {$this->tables['nodes_hierarchy']} " .
                    " WHERE  node_type_id = 5 and id = {$job['tplan_id']}";
         $exec = $this->db->get_recordset($tempsql);
         if(!is_null($exec)){
              $myjob['tplan'] = $exec[0]['name'];
         }else{$myjob['tplan'] = '已删除';}
        
          //get build name
          $tempsql = "/* $debugMsg */ SELECT name " .
                     " FROM {$this->tables['builds']} " .
                     " WHERE  testplan_id = {$job['tplan_id']} and id = {$job['build_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['build'] = $exec[0]['name'];
          }else{$myjob['build'] = '已删除';}
          //get device name
          $tempsql = "/* $debugMsg */ SELECT name " .
                     " FROM {$this->tables['platforms']} " .
                     " WHERE  id = {$job['device_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['device'] = $exec[0]['name'];
          }else{$myjob['device'] = '已删除';}
          //get user name
          $tempsql = "/* $debugMsg */ SELECT login FROM {$this->tables['users']} WHERE  id = {$job['user_id']}";
          $exec = $this->db->get_recordset($tempsql);
          if(!is_null($exec)){
               $myjob['user'] = $exec[0]['login'];
          }else{$myjob['user'] = '不存在';}
          $myjob['job_id'] = $job['job_id'];
          $myjob['status'] = $job['status'];
          $myjob['job_type'] = $job['job_type'];
          $myjob['tplan_id'] = $job['tplan_id'];
          $myjob['device_id'] = $job['device_id'];
          $myjob['build_id'] = $job['build_id'];
          $myjob['job_startTime'] = $job['job_startTime'];
          $myjob['job_endTime'] = $job['job_endTime'];
          $myjob['total_case'] = $job['total_case'];
          $myjob['runend_case'] = $job['runend_case'];
          $myjob['pass_case'] = $job['pass_case'];
          $myjob['fail_case'] = $job['fail_case'];
          $myjob['olddiff_case'] = $job['olddiff_case'];
          $myjob['na_case'] = $job['na_case'];
          $myjob['accept_case'] = $job['accept_case'];
          $myjob['topo_type'] = $job['topo_type'];
          $myjob['endwhy'] = $job['endwhy'];

          $runend_jobs[] = $myjob;
    }

    return $runend_jobs;
  }

  public function getAllCloudjobs()
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;  	
  	$sql =  "/* $debugMsg */ SELECT * FROM run_cloud_jobs WHERE productline_id = {$this->tproject_id} ";
  	
  	$temprs = $this->db->get_recordset($sql);
  	$cloud_jobs = array();
  	foreach($temprs as $job){
  		//get test plan name
  		$tempsql = "/* $debugMsg */ SELECT name " .
  		" FROM {$this->tables['nodes_hierarchy']} " .
  		" WHERE node_type_id = 5 and id = {$job['tplan_id']}";
  		$exec = $this->db->get_recordset($tempsql);
  		if(!is_null($exec)){
  			$myjob['tplan'] = $exec[0]['name'];
  		}else{$myjob['tplan'] = '已删除';}
  	
  		//get build name
  		$tempsql = "/* $debugMsg */ SELECT name " .
  		" FROM {$this->tables['builds']} " .
  		" WHERE testplan_id = {$job['tplan_id']} and id = {$job['build_id']}";
  		$exec = $this->db->get_recordset($tempsql);
  		if(!is_null($exec)){
  			$myjob['build'] = $exec[0]['name'];
  		}else{$myjob['build'] = '已删除';}
  		//get device name
  		$tempsql = "/* $debugMsg */ SELECT name " .
  		" FROM {$this->tables['platforms']} " .
  		" WHERE  id = {$job['device_id']}";
  		$exec = $this->db->get_recordset($tempsql);
  		if(!is_null($exec)){
  			$myjob['device'] = $exec[0]['name'];
  		}else{$myjob['device'] = '已删除';}
  		//get user name
  		$tempsql = "/* $debugMsg */ SELECT login FROM {$this->tables['users']} WHERE  id = {$job['user_id']}";
  		$exec = $this->db->get_recordset($tempsql);
  		if(!is_null($exec)){
  			$myjob['user'] = $exec[0]['login'];
  		}else{$myjob['user'] = '不存在';}
  		$myjob['status'] = $job['status'];
  		$myjob['job_id'] = $job['job_id'];
  		$myjob['topo_type'] = $job['topo_type'];
  		$myjob['module'] = $job['module'];
  		$myjob['device_id'] = $job['device_id'];
  		$myjob['build_id'] = $job['build_id'];
  		$myjob['start_time'] = $job['start_time'];
  		$myjob['env_id'] = $job['env_id'];
  		$myjob['total_case'] = $job['total_case'];
  		$myjob['worker'] = $job['worker'];
  		
  		$temp = explode('-', $job['job_id']);
  		$parent_jobid = $temp[0];
  		$module = $temp[1];
  		
  		if( !isset($cloud_jobs[$parent_jobid]) ){
  			$cloud_jobs[$parent_jobid] = array();
  		}
  		if( !isset($cloud_jobs[$parent_jobid][0]) ){
  			$cloud_jobs[$parent_jobid][0] = $myjob;
  		}
  		$cloud_jobs[$parent_jobid][$module] = $myjob;
  	}
  	return $cloud_jobs;
  }
  
  public function userCanDeleteJob($username)
 {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = " SELECT role_id FROM users WHERE login = '{$username}' ";
    $rs = $this->db->get_recordset($sql);
    if( $rs[0]['role_id']==1 || $rs[0]['role_id']==8 ){
    	return 1;
    }else{
    	return 0;
    }
 }
  
  public function getSpecialJob($job_id)
 {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;

    $filter = " WHERE productline_id = {$this->tproject_id} AND job_id = '{$job_id}' ";
    
    $sql =  "/* $debugMsg */ SELECT * FROM running_jobs {$filter} ";
    $job = $this->db->get_recordset($sql);
    $job = $job[0] ;

    //get build name
    $tempsql = "/* $debugMsg */ SELECT name FROM builds WHERE testplan_id = {$job['tplan_id']} and id = {$job['build_id']}";
    $exec = $this->db->get_recordset($tempsql);
    if(!is_null($exec)){
         $job['build'] = $exec[0]['name'];
    }
    //get device name
    $tempsql = "/* $debugMsg */ SELECT name FROM {$this->tables['platforms']} WHERE  id = {$job['device_id']}";
    $exec = $this->db->get_recordset($tempsql);
    if(!is_null($exec)){
         $job['device'] = $exec[0]['name'];
    }
    //get test plan name
    $tempsql = "/* $debugMsg */ SELECT name FROM {$this->tables['nodes_hierarchy']} " .
               " WHERE  node_type_id = 5 and id = {$job['tplan_id']}";
    $exec = $this->db->get_recordset($tempsql);
    if(!is_null($exec)){
         $job['tplan'] = $exec[0]['name'];
    }

    //get user name
    $tempsql = "/* $debugMsg */ SELECT login FROM {$this->tables['users']} WHERE  id = {$job['user_id']}";
    $exec = $this->db->get_recordset($tempsql);
    if(!is_null($exec)){
         $job['user'] = $exec[0]['login'];
    }
    switch($job['job_type']){
       case 'affirm2':
              $sql =  "/* $debugMsg */ SELECT * FROM affirm2_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break;
        case 'affirm3' :
        case 'affirm3|affirm2' :      
              $sql =  "/* $debugMsg */ SELECT * FROM affirm3_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'college' :
              $sql =  "/* $debugMsg */ SELECT * FROM a_college_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'oversea' :
              $sql =  "/* $debugMsg */ SELECT * FROM a_oversea_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'financial' :
              $sql =  "/* $debugMsg */ SELECT * FROM a_financial_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'IGMPSnp性能':
        case 'IGMPSnp时延':
        case '协议收包缓冲':
        case '板间协议处理':
        case 'softperformance':
              $sql =  "/* $debugMsg */ SELECT * FROM v_performance_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'function' :
              $sql =  "/* $debugMsg */ SELECT * FROM function_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
        case 'cmdauto' :
              $sql =  "/* $debugMsg */ SELECT * FROM a_cmd_exec_record WHERE job_id = '{$job_id}' ";
              $rs = $this->db->get_recordset($sql);
              $job = array_merge($job,$rs[0]);
              break ;
     }
         
     switch($job['status']){
         case '1' :
               $job['status'] = '正在执行中' ;
               break ;
         case '0' :
               $job['status'] = '暂停' ;
               break ;
               default :
    }
    $job['process'] = round($job['runend_case']*100/$job['total_case'],2) . '%';

    return $job;
  }

  public function getJobExist($productline_id, $tplan_id, $device_id, $build_id, $module)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT name FROM builds WHERE id={$build_id} " ;
    $rs = $this->db->get_recordset($sql);
    $build_name = $rs[0]['name'];
    $module = (string)$module;
    if( $build_name == 'Dynamic Create' ){
        return false;
    }else{
        $filter = " WHERE productline_id = {$productline_id} AND tplan_id = {$tplan_id} AND device_id = {$device_id} AND build_id = {$build_id} AND job_type LIKE '%{$module}%'  " ;
        $sql =  "/* $debugMsg */ SELECT job_id FROM running_jobs {$filter} ";
        $rs = $this->db->get_recordset($sql);

        if(is_null($rs)){
            return false;
         }
         else{
            return true;
         }
    }
  }

  public function jobtrash($jobid)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT * FROM running_jobs WHERE job_id='{$jobid}'" ;
    $rs = $this->db->get_recordset($sql);
    $job = $rs[0];
   
    $now_time = "'".date("Y:m:d")." ".date("H:i:s")."'";

    $sql =  "/* $debugMsg */ INSERT INTO run_end_jobs " .
 	    " ( job_id ,status, topo_type , job_type ,job_startTime, job_endTime, productline_id, tplan_id, build_id, device_id, total_case, pass_case, fail_case, accept_case, block_case, na_case, skip_case, warn_case, user_id, running_vdi,runend_case)" .

            " VALUES ( '{$job['job_id']}', 0,{$job['topo_type']},'{$job['job_type']}', '{$job['job_startTime']}', {$now_time}, {$job['productline_id']}, {$job['tplan_id']}, {$job['build_id']},{$job['device_id']},{$job['total_case']},{$job['pass_case']},{$job['fail_case']},{$job['accept_case']},{$job['block_case']},{$job['na_case']},{$job['skip_case']},{$job['warn_case']},{$job['user_id']}, '{$job['running_vdi']}',{$job['runend_case']} ) ";
    $this->db->exec_query($sql);

    $sql =  "/* $debugMsg */ SELECT job_id FROM run_end_jobs WHERE job_id='{$jobid}' " ;
    $rs = $this->db->get_recordset($sql);
    if( !is_null($rs)  ){
            $sql =  "/* $debugMsg */ DELETE FROM running_jobs WHERE job_id='{$jobid}' " ;
            $this->db->exec_query($sql);
            return 1;
       }else{  
           return 0;
      }
  }

  public function addJob($jobid, $platform, $jobtype, $total_case, $productline_id, $tplan_id, $device_id, $build_id, $user, $client_ip,$suite)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT id FROM users WHERE login = '{$user}'" ;
    $rs = $this->db->get_recordset($sql);
    $user_id = $rs[0]['id'];

    $run_time = " ' " . date("H:i:s") . " ' ";

    $sql =  "/* $debugMsg */ INSERT INTO running_jobs " .
 	    " ( job_id, job_type, total_case, productline_id, tplan_id, device_id, build_id, user_id, running_vdi,run_time)" .

            " VALUES ( '{$jobid}', '{$jobtype}', {$total_case}, {$productline_id}, {$tplan_id}, {$device_id}, {$build_id}, {$user_id}, '{$client_ip}', {$run_time} ) ";
    $this->db->exec_query($sql);

    //$sql =  "/* $debugMsg */ SELECT tcversion_id FROM {$this->tables['testplan_tcversions']} WHERE testplan_id ={$tplan_id} AND platform_id = {$device_id} ";
    
    if($platform == 'moni'){
    	$sql = " SELECT TPTCV.tcversion_id FROM testplan_tcversions as TPTCV,tcversions as TCV " .
    			" WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id={$tplan_id} AND TPTCV.platform_id={$device_id} AND TPTCV.active=1 AND TPTCV.skip!=1 AND TCV.preconditions LIKE '%.tcl' ";
    }elseif($platform == 'dauto'){
    	$sql = " SELECT TPTCV.tcversion_id FROM testplan_tcversions as TPTCV,tcversions as TCV " .
    			" WHERE TPTCV.tcversion_id = TCV.id AND TPTCV.testplan_id={$tplan_id} AND TPTCV.platform_id={$device_id} AND TPTCV.active=1 AND TPTCV.skip!=1 AND TCV.preconditions LIKE '%.py' ";
    }else{
    	$sql =  " SELECT tcversion_id FROM testplan_tcversions WHERE testplan_id={$tplan_id} AND platform_id={$device_id} AND active=1 AND skip!=1 ";
    }
    $cases = $this->db->get_recordset($sql);
   
    foreach($cases as $testcase){
        $sql =  "/* $debugMsg */ SELECT parent_id FROM nodes_hierarchy WHERE `id`= {$testcase['tcversion_id']} " ;
        $rs = $this->db->fetchFirstRow($sql);
       
        $sql =  "/* $debugMsg */ SELECT parent_id,name FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
        $rs = $this->db->fetchFirstRow($sql);
        $casename = $rs['name'];

        $sql =  "/* $debugMsg */ SELECT name FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
        $rs = $this->db->fetchFirstRow($sql);

        if($suite=='affirm3|affirm2'){
        	if( ($rs['name'] == '确认测试3.0') or ($rs['name'] == '确认测试2.0') ){
        		$sql =  "/* $debugMsg */ INSERT INTO job_testcase ( job_id, testcase) VALUES ( '{$jobid}', {$testcase['tcversion_id']} ) ";
        		$this->db->exec_query($sql);
        	}
        }elseif( preg_match("/^\(.*?\)/i",$suite) ){
        	if( preg_match("/" . $rs['name'] ."/i",$suite) ){
        		$sql =  "/* $debugMsg */ INSERT INTO job_testcase ( job_id, testcase) VALUES ( '{$jobid}', {$testcase['tcversion_id']} ) ";
        		$this->db->exec_query($sql);
        	}
        }else{
        	if($rs['name'] == $suite){
        		$sql =  "/* $debugMsg */ INSERT INTO job_testcase ( job_id, testcase) VALUES ( '{$jobid}', {$testcase['tcversion_id']} ) ";
        		$this->db->exec_query($sql);
        	}
        }
     }
  }

  public function addCloudJob($jobid, $location,$topo_type,$module, $total_case, $productline_id, $tplan_id, $device_id, $build_id, $user_name){
  	switch($module){
  		case 'affirm2':
  			$suite = '确认测试2.0';
  			break;
  		case 'affirm3':
  			$suite = '确认测试3.0';
  			break;
  		default:
			$suite = $module;
  			break;
  	}
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql = "/* $debugMsg */ SELECT id FROM users WHERE login = '{$user_name}'" ;
  	$rs = $this->db->get_recordset($sql);
  	$user_id = $rs[0]['id'];
  	
  	$start_time = strftime("%Y-%m-%d %H:%m:%s",time());
  	
  	$sql =  "/* $debugMsg */ INSERT INTO run_cloud_jobs " .
  	" ( job_id,location,topo_type,module,total_case,status,start_time,productline_id,tplan_id,device_id,build_id,user_id)" .
  	" VALUES ( '{$jobid}','{$location}','{$topo_type}', '{$module}', {$total_case},'wait','{$start_time}',{$productline_id}, {$tplan_id}, {$device_id}, {$build_id}, {$user_id} ) ";

  	$this->db->exec_query($sql);

  	$sql =  "/* $debugMsg */ SELECT tcversion_id FROM {$this->tables['testplan_tcversions']} WHERE testplan_id={$tplan_id} AND platform_id={$device_id} ";
  	$cases = $this->db->get_recordset($sql);
  	 
  	foreach($cases as $testcase){
  		$sql =  "/* $debugMsg */ SELECT parent_id FROM nodes_hierarchy WHERE `id`= {$testcase['tcversion_id']} " ;
  		$rs = $this->db->fetchFirstRow($sql);
  		 
  		$sql =  "/* $debugMsg */ SELECT parent_id,name FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
  		$rs = $this->db->fetchFirstRow($sql);
  		$casename = $rs['name'];
  	
  		$sql =  "/* $debugMsg */ SELECT name FROM nodes_hierarchy WHERE `id`= {$rs['parent_id']} " ;
  		$suitename = $this->db->fetchFirstRow($sql);
  	
		if($suitename['name'] == $suite){
  			$sql =  "/* $debugMsg */ INSERT INTO job_testcase ( job_id, testcase) VALUES ( '{$jobid}', {$testcase['tcversion_id']} ) ";
  			$this->db->exec_query($sql);
  		}
  	}
  }
  
  public function addAffirm2Run($job_id, $platform, $s1ip, $s2ip, $s2device, $s1sn, $s2sn, $s1p1, $s1p2, $s1p3, $s2p1, $s2p2, $s2p3, $ixia_ip, $tp1, $tp2, $productversion, $scriptversion)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql =  "/* $debugMsg */ INSERT INTO affirm2_exec_record " .
 	    " ( job_id, platform, s1ip, s2ip, s2device, s1sn, s2sn, s1p1, s1p2, s1p3, s2p1, s2p2, s2p3, ixia_ip, tp1, tp2 ,productVersion ,scriptVersion)" .
            " VALUES ( '{$job_id}','{$platform}', '{$s1ip}', '{$s2ip}', '{$s2device}', '{$s1sn}', '{$s2sn}', '{$s1p1}', '{$s1p2}', '{$s1p3}', '{$s2p1}', '{$s2p2}', '{$s2p3}', '{$ixia_ip}', '{$tp1}', '{$tp2}' ,'{$productversion}', '{$scriptversion}' ) ";
    return $this->db->exec_query($sql);
  }
  
  public function addAffirm3Run($job_id, $s1ip, $s4ip, $s1p1, $s1p2, $s1p3, $s1p4, $s1p5, $s1p6, $s1p7, $s1device, $s2ip, $s5ip, $s2p1, $s2p2, $s2p3, $s2p4, $s2p5, $s2p6, $s2p7, $s2p8, $s2p9, $s2p10, $s2p11, $s2p12, $s2device, $ixia_ip, $tp1, $tp2, $s6ip, $s6p1, $s6p2, $server, $client, $admin_ip, $radius)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql =  "/* $debugMsg */ INSERT INTO affirm3_exec_record " .
 	   " (job_id,s1ip,s4ip,s1p1,s1p2,s1p3,s1p4,s1p5,s1p6,s1p7, s1device,s2ip,s5ip,s2p1,s2p2,s2p3,s2p4,s2p5,s2p6,s2p7,s2p8,s2p9,s2p10,s2p11,s2p12,s2device,ixia_ip,tp1,tp2,s6ip,s6p1,s6p2,server,client,admin_ip,radius )" .
            " VALUES ( '{$job_id}','{$s1ip}','{$s4ip}','{$s1p1}','{$s1p2}','{$s1p3}','{$s1p4}','{$s1p5}','{$s1p6}','{$s1p7}','{$s1device}','{$s2ip}','{$s5ip}','{$s2p1}','{$s2p2}','{$s2p3}','{$s2p4}','{$s2p5}','{$s2p6}','{$s2p7}','{$s2p8}','{$s2p9}','{$s2p10}','{$s2p11}','{$s2p12}','{$s2device}','{$ixia_ip}','{$tp1}','{$tp2}','{$s6ip}','{$s6p1}','{$s6p2}','{$server}','{$client}','{$admin_ip}','{$radius}' ) ";

    return $this->db->exec_query($sql);
  }

  public function addCmdAutoRun($job_id, $s1ip)
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO a_cmd_exec_record " .
  	" ( job_id, s1ip)" .
  	" VALUES ( '{$job_id}', '{$s1ip}' ) ";
  	return $this->db->exec_query($sql);
  }
  
  public function addMemoryTesttRun($job_id, $s1ip, $details)
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO a_memorytest_exec_record " .
  	" ( job_id, s1ip, details)" .
  	" VALUES ( '{$job_id}', '{$s1ip}', '{$details}' ) ";
  	return $this->db->exec_query($sql);
  }
  
  
  public function addWirelessAffirmRun($job_id,$env_id,$s1ip,$s1name,$s1p1,$s2ip,$s2name,$s2p1,$s3ip,$s3name,$s3p1,$s3p2,$s3p3,$s3p4,$s3p5,$s3p6,$pc1,$tester_wired,$sta1,$sta2,$ap1,$ap1name,$ap2,$ap2name,$setdefault,$upgrade)
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO affirmwireless_exec_record " .
  			" ( job_id,waffirmenv,s1ip,s1name,s1p1,s2ip,s2name,s2p1,s3ip,s3name,s3p1,s3p2,s3p3,s3p4,s3p5,s3p6,pc1ip,testerip_wired,sta1ip,sta2ip,ap1ip,ap1name,ap2ip,ap2name,setdefault,upgrade)" .
  			" VALUES ( '{$job_id}','{$env_id}', '{$s1ip}', '{$s1name}', '{$s1p1}', '{$s2ip}', '{$s2name}', '{$s2p1}', '{$s3ip}', '{$s3name}', '{$s3p1}', '{$s3p2}', '{$s3p3}', '{$s3p4}', '{$s3p5}', '{$s3p6}', '{$pc1}', '{$tester_wired}', '{$sta1}' ,'{$sta2}', '{$ap1}', '{$ap1name}','{$ap2}','{$ap2name}','{$setdefault}','{$upgrade}' ) ";
  	return $this->db->exec_query($sql);
  }
  
  public function addCollegeRun(
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
    				){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO a_college_exec_record " .
  			" (job_id, ixia, tp1, tp2, tp3,
    				s1ip, s1p1, s1p2, s1p3, s1p4, s1p5, s1p6,
    				s2ip, s2p1, s2p2, s2p3, s2p4, s2p5,
    				s3ip, s3p1, s3p2, s3p3, 
    				s4ip, s4p1, s4p2, s4p3,
    				s5ip, s5p1, s5p2, s5p5, s5p6, s5p7, s5p8, s5p9, s5p10, s5p11, s5p12, s5p13, s5p14, s5p15, s5p16, s5p17, s5p19,
    				s5p5to14,
    				s6ip, s6p1, s6p2, s6p3, s6p4, s6p5, s6p6, s6p7, s6p8, s6p9, s6p10, s6p11, s6p12, s6p13, s6p14, s6p15, s6pall,
    				s6p3to12,
    				s7ip, s7p1, s7p2, s7p3,
    				s8ip, s8p5, s8p6, s8p7, s8p8, s8p9, s8p10, s8p11, s8p12, s8p13, s8p14,
    				s9ip, s9p3, s9p4, s9p5, s9p6, s9p7, s9p8, s9p9, s9p10, s9p11, s9p12,
    				apcip, apcport
    				) " .
  			" VALUES ( 
  	                '{$jobid}', 
  	                '{$ixia}', '{$tp1}', '{$tp2}', '{$tp3}',
  	                '{$s1ip}', '{$s1p1}', '{$s1p2}', '{$s1p3}', '{$s1p4}', '{$s1p5}', '{$s1p6}',
    				'{$s2ip}', '{$s2p1}', '{$s2p2}', '{$s2p3}', '{$s2p4}', '{$s2p5}',
    				'{$s3ip}', '{$s3p1}', '{$s3p2}', '{$s3p3}', 
    				'{$s4ip}', '{$s4p1}', '{$s4p2}', '{$s4p3}',
    				'{$s5ip}', '{$s5p1}', '{$s5p2}', '{$s5p5}', '{$s5p6}', '{$s5p7}', '{$s5p8}', '{$s5p9}', '{$s5p10}', '{$s5p11}', '{$s5p12}', '{$s5p13}', '{$s5p14}', '{$s5p15}', '{$s5p16}', '{$s5p17}', '{$s5p19}',
    				'{$s5p5to14}',
    				'{$s6ip}', '{$s6p1}', '{$s6p2}', '{$s6p3}', '{$s6p4}', '{$s6p5}', '{$s6p6}', '{$s6p7}', '{$s6p8}', '{$s6p9}', '{$s6p10}', '{$s6p11}', '{$s6p12}', '{$s6p13}', '{$s6p14}', '{$s6p15}', '{$s6pall}',
    				'{$s6p3to12}',
    				'{$s7ip}', '{$s7p1}', '{$s7p2}', '{$s7p3}',
    				'{$s8ip}', '{$s8p5}', '{$s8p6}', '{$s8p7}', '{$s8p8}', '{$s8p9}', '{$s8p10}', '{$s8p11}', '{$s8p12}', '{$s8p13}', '{$s8p14}',
    				'{$s9ip}', '{$s9p3}', '{$s9p4}', '{$s9p5}', '{$s9p6}', '{$s9p7}', '{$s9p8}', '{$s9p9}', '{$s9p10}', '{$s9p11}', '{$s9p12}',
    				'{$apcip}', '{$apcport}'
    				) " ;  
  	return $this->db->exec_query($sql);
  }
  
  public function addOverseaRun(
  		$jobid, 
    	$ixia, $tp1, $tp2, $tp3,
    	$s3ip, $s3p4, $s3p5, $s3p6,
    	$s4ip, $s4p4, $s4p5, 
    	$s8ip, $s8p1, $s8p2, $s8p3, $s8p4, $s8p5, $s8p6, $s8p7, $s8p8,
    	$s9ip, $s9p1, $s9p2, $s9p3, $s9p4, 
    	$pcip
    	){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO a_oversea_exec_record " .
  	" (job_id, 
        ixia, tp1, tp2, tp3,
    	s3ip, s3p4, s3p5, s3p6,
    	s4ip, s4p4, s4p5, 
    	s8ip, s8p1, s8p2, s8p3, s8p4, s8p5, s8p6, s8p7, s8p8,
    	s9ip, s9p1, s9p2, s9p3, s9p4, 
    	pcip) " .
     " VALUES (
      	'{$jobid}', 
      	'{$ixia}', '{$tp1}', '{$tp2}', '{$tp3}',
    	'{$s3ip}', '{$s3p4}', '{$s3p5}', '{$s3p6}',
    	'{$s4ip}', '{$s4p4}', '{$s4p5}', 
    	'{$s8ip}', '{$s8p1}', '{$s8p2}', '{$s8p3}', '{$s8p4}', '{$s8p5}', '{$s8p6}', '{$s8p7}', '{$s8p8}',
    	'{$s9ip}', '{$s9p1}', '{$s9p2}', '{$s9p3}', '{$s9p4}', 
    	'{$pcip}' ) " ;
    return $this->db->exec_query($sql);
  }

  public function addFinancialRun(
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
  ){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO a_financial_exec_record " .
  	" (job_id,
    ixia, tp1, tp2,
    pc1ip, pc2ip,
    s1ip, s1p1, s1p2, s1p3, s1p4, s1p5, s1p6, s1p7, s1p8, s1p9, s1p10, s1p11, s1p12, s1p13, s1p14, s1p15, s1p16, s1p17, s1p18, s1p1to18, s1p19, s1p21, s1p22, s1p23, s1p25, s1p26, s1p36, s1p47,
    s2ip, s2p1, s2p2, s2p3, s2p23, 
    s3ip, s3p1, s3p2, s3p3, s3p14,
    s4ip, s4p1, s4p2, s4p3,
    s5ip,
    s6ip, s6p1, s6p2, s6p3,
    s7ip, s7p1, s7p2,
    apcip, apcport) " .
       " VALUES (
       '{$jobid}',
       '{$ixia}', '{$tp1}', '{$tp2}',
       '{$pc1}', '{$pc2}',
       '{$s1ip}', '{$s1p1}', '{$s1p2}', '{$s1p3}', '{$s1p4}', '{$s1p5}', '{$s1p6}', '{$s1p7}', '{$s1p8}', '{$s1p9}', '{$s1p10}', '{$s1p11}', '{$s1p12}', '{$s1p13}', '{$s1p14}', '{$s1p15}', '{$s1p16}', '{$s1p17}', '{$s1p18}', '{$s1p1to18}', '{$s1p19}', '{$s1p21}', '{$s1p22}', '{$s1p23}', '{$s1p25}', '{$s1p26}', '{$s1p36}', '{$s1p47}',
       '{$s2ip}', '{$s2p1}', '{$s2p2}', '{$s2p3}', '{$s2p23}', 
       '{$s3ip}', '{$s3p1}', '{$s3p2}', '{$s3p3}', '{$s3p14}',
       '{$s4ip}', '{$s4p1}', '{$s4p2}', '{$s4p3}',
       '{$s5ip}',
       '{$s6ip}', '{$s6p1}', '{$s6p2}', '{$s6p3}',
       '{$s7ip}', '{$s7p1}', '{$s7p2}',
       '{$apcip}', '{$apcport}' ) " ;
  	return $this->db->exec_query($sql);
  }

  public function addPerformanceRun(
  		$jobid,
    	$ixiaip, $ixiaport,$ixiaport_num,
    	$s1ip, $s1port,
    	$trial, $interval, $debug,$detail
  ){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql =  "/* $debugMsg */ INSERT INTO v_performance_exec_record " .
  	" (job_id,
  	   ixiaip, ixiaport,tp_number,
       s1ip,s1port,
       testTrial,test_interval,DEBUG,par_detail) " .
      " VALUES (
      '{$jobid}',
      '{$ixiaip}', '{$ixiaport}','{$ixiaport_num}',
      '{$s1ip}', '{$s1port}',
      '{$trial}', '{$interval}', '{$debug}','{$detail}' ) " ;

      return $this->db->exec_query($sql);
  }

  public function addFunctionRun($job_id, $env_id, $module, $details, $details_adv)
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$para = $details . "\n" . $details_adv ;
  	$sql =  "/* $debugMsg */ INSERT INTO function_exec_record " .
  	" ( job_id, env_id, modules, details)" .
  	" VALUES ( '{$job_id}','{$env_id}', '{$module}', '{$para}' ) ";
  	return $this->db->exec_query($sql);
  }
  
  public function getDeviceName($productline, $device)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT name FROM platforms WHERE testproject_id = '{$productline}' AND id = '{$device}'" ;
    $rs = $this->db->get_recordset($sql);

    return $rs[0]['name'];
  }

  public function getAllAffirm3Env()
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT * FROM affirm3_env " ;

    $rs = $this->db->fetchRowsIntoMap($sql,'env_id');

    return $rs;
  }
  
  public function getAllFunctionEnv()
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql = "/* $debugMsg */ SELECT * FROM function_env " ;
  	$rs = $this->db->fetchRowsIntoMap($sql,'env_id');
  	return $rs;
  }

  public function getPoncatAllFunctionEnv()
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$poncat1 = "SetDefaultInitCommand1 {interface Ethernet1/0/13-24;3/0/13-24} {combo-forced-mode copper-forced} exit {ipv4 hardware forwarding enable} {ipv6 hardware forwarding enable} RELOAD\n";
  	$poncat2 = "SetDefaultInitCommand2 {interface Ethernet1/0/13-24} {combo-forced-mode copper-forced} exit {ipv4 hardware forwarding enable} {ipv6 hardware forwarding enable} RELOAD\n";
  	$sql = "/* $debugMsg */ SELECT * FROM function_env " ;
  	$rs = $this->db->fetchRowsIntoMap($sql,'env_id');
  	foreach( $rs as $key=>$value){
  		$rs[$key]['details'] =  $poncat1 . $poncat2 . $rs[$key]['details'];
  	}
  	return $rs;
  }
  
  public function getAllWirelessAffirmEnv()
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql = "/* $debugMsg */ SELECT * FROM affirmwireless_env " ;
  
  	$rs = $this->db->fetchRowsIntoMap($sql,'env_id');
  
  	return $rs;
  }
  
  public function getJobHistory($tplan,$user)
  {
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT id FROM users WHERE login = '{$user}'" ;
    $rs = $this->db->get_recordset($sql);
    $user_id = $rs[0]['id'];

    $sql = "/* $debugMsg */ SELECT job_id,job_type FROM run_end_jobs WHERE tplan_id = {$tplan} AND user_id = {$user_id}  AND job_type = 'affirm2' ORDER BY job_endTime DESC" ;
    $job['affirm2'] = $this->db->fetchFirstRow($sql);

    $sql = "/* $debugMsg */ SELECT job_id,job_type FROM run_end_jobs WHERE tplan_id = {$tplan} AND user_id = {$user_id} AND job_type LIKE 'affirm3%' ORDER BY job_endTime DESC" ;
    $job['affirm3'] = $this->db->fetchFirstRow($sql);
    
    if( !is_null( $job['affirm2']) ){
            $sql = "/* $debugMsg */ SELECT * FROM affirm2_exec_record WHERE job_id = '{$job['affirm2']['job_id']}'  ORDER BY create_ts DESC " ;
            $job['affirm2'] = $this->db->fetchFirstRow($sql);
    }
    if( !is_null($job['affirm3']) ){
           $sql = "/* $debugMsg */ SELECT * FROM affirm3_exec_record WHERE job_id = '{$job['affirm3']['job_id']}'   ORDER BY create_ts DESC " ;
           $job['affirm3'] = $this->db->fetchFirstRow($sql);
    }
    return $job;
  }

  public function getParDetail($device_id){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql = "/* $debugMsg */ SELECT performance_id FROM platforms WHERE id = {$device_id} " ;
  	$rs = $this->db->fetchFirstRow($sql);
  	
  	$sql = "/* $debugMsg */ SELECT PA.text as '1',PB.text as '2',PC.text as '3',PD.text as '4' " . 
  		   " FROM var_performance as VP,v_igmpsnooping_ability as PA,v_igmpsnooping_delay as PB,v_protocol_buffer_length as PC,v_crossboard_protocol_ability as PD " . 
  	       " WHERE VP.id = {$rs['performance_id']} AND VP.a=PA.id AND VP.b=PB.id AND VP.c=PC.id AND VP.d=PD.id " ;
  	return $this->db->fetchFirstRow($sql);
  }
  
  public function isPoncatFunctionVar($device_id){
  	$debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
  	$sql = "/* $debugMsg */ SELECT V.name FROM vars as V,platforms as P WHERE P.id = {$device_id} AND P.function_var = V.id " ;
  	$rs = $this->db->get_recordset($sql);
  	$returnrs = 0 ;
  	if( !is_null($rs)){
  		if( $rs[0]['name'] == 'poncat'){
  			$returnrs = 1;
  		}
  	}
  	return $returnrs ;  	
  }
  /**
   * get all available platforms in the active testproject ($this->tproject_id)
   * @param string $orderBy
   * @return array Returns 
   *               as array($platform_id => $platform_name)
   */
  public function getAllAsMap($accessKey='id',$output='columns',$orderBy=' ORDER BY name ')
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql =  "/* $debugMsg */  SELECT id, name " .
        " FROM {$this->tables['platforms']} " .
        " WHERE testproject_id = {$this->tproject_id} {$orderBy}";
    if( $output == 'columns' )
    {
      $rs = $this->db->fetchColumnsIntoMap($sql, $accessKey, 'name');
    }
    else
    {
      $rs = $this->db->fetchRowsIntoMap($sql, $accessKey);
    }  
    return $rs;
  }

  /**
   * Logic to determine if platforms should be visible for a given testplan.
   * @return bool true if the testplan has one or more linked platforms;
   *              otherwise false.
   */
  public function platformsActiveForTestplan($testplan_id)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = "/* $debugMsg */ SELECT COUNT(0) AS num " .
         " FROM {$this->tables['testplan_platforms']} " .
         " WHERE testplan_id = {$testplan_id}";
    $num_tplans = $this->db->fetchOneValue($sql);
    return ($num_tplans > 0);
  }

  /**
   * @param map $options
   * @return array Returns all platforms associated to a given testplan
   *
   * @internal revision
   * 20100705 - franciscom - interface - BUGID 3564
   *
   */
  public function getLinkedToTestplan($testplanID, $options = null)
  {
    // output:
    // array => indexed array
    // mapAccessByID => map access key: id
    // mapAccessByName => map access key: name
    $my['options'] = array('outputFormat' => 'array', 'orderBy' => ' ORDER BY name ');
    $my['options'] = array_merge($my['options'], (array)$options);
    
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $rs = null;
    $sql = "/* $debugMsg */ SELECT P.id, P.name, P.notes " .
           " FROM {$this->tables['platforms']} P " .
           " JOIN {$this->tables['testplan_platforms']} TP " .
           " ON P.id = TP.platform_id " .
           " WHERE  TP.testplan_id = {$testplanID} {$my['options']['orderBy']}";
    
    switch($my['options']['outputFormat'])
    {
      case 'array':
        $rs = $this->db->get_recordset($sql);
      break;
      
      case 'mapAccessByID':
        $rs = $this->db->fetchRowsIntoMap($sql,'id');
      break;
      
      case 'mapAccessByName':
        $rs = $this->db->fetchRowsIntoMap($sql,'name');
      break;
    }     
    return $rs;
  }

    //add by guomf for report custom
    //get platforms linked to testplan which has execution record on a special build
    public function getLinkedToTestplanExecuted($testplanID, $buildID, $options = null)
    {
        $my['options'] = array('outputFormat' => 'array', 'orderBy' => ' ORDER BY name ');
        $my['options'] = array_merge($my['options'], (array)$options);
        $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
        $rs = null;
        $sql = "/* $debugMsg */ SELECT P.id, P.name, P.notes" .
               " FROM {$this->tables['platforms']} P " .
               " JOIN {$this->tables['testplan_platforms']} TP " .
               " ON P.id = TP.platform_id " .
               " WHERE  TP.testplan_id = {$testplanID} {$my['options']['orderBy']}";
        $rs = $this->db->fetchRowsIntoMap($sql,'id');
        $mydevice = array();
        foreach($rs as $platform){
               $tempsql = "/* $debugMsg */ SELECT status " .
                          " FROM {$this->tables['executions']} " .
                          " WHERE  testplan_id = {$testplanID} and build_id = {$buildID} and platform_id = {$platform['id']} ";
               $executions = $this->db->get_recordset($tempsql);
               if(!is_null($executions)){
                    $mydevice[$platform['id']] = $platform;
               }

        }
       return $mydevice;
   }



  public function getLinkedToTestplanAsMapExecuted($testplanID,$buildID, $orderBy=' ORDER BY name ')
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql =  "/* $debugMsg */ SELECT P.id, P.name " .
            " FROM {$this->tables['platforms']} P " .
            " JOIN {$this->tables['testplan_platforms']} TP " .
            " ON P.id = TP.platform_id " .
            " WHERE  TP.testplan_id = {$testplanID} {$orderBy}";
    $rs = $this->db->fetchColumnsIntoMap($sql, 'id', 'name');
     $rs_name_id = array_flip($rs); 
       foreach($rs_name_id as $platform){
               $tempsql = "/* $debugMsg */ SELECT status " .
                          " FROM {$this->tables['executions']} " .
                          " WHERE  testplan_id = {$testplanID} and build_id = {$buildID} and platform_id = {$platform} ";
               $executions = $this->db->get_recordset($tempsql);
               if(is_null($executions)){
                    unset($rs[$platform]);
               }

        }
       return $rs;

  }


  /**
   * @param string $orderBy
   * @return array Returns all platforms associated to a given testplan
   *               on the form $platform_id => $platform_name
   */
  public function getLinkedToTestplanAsMap($testplanID,$orderBy=' ORDER BY name ')
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql =  "/* $debugMsg */ SELECT P.id, P.name " .
            " FROM {$this->tables['platforms']} P " .
            " JOIN {$this->tables['testplan_platforms']} TP " .
            " ON P.id = TP.platform_id " .
            " WHERE  TP.testplan_id = {$testplanID} {$orderBy}";
    return $this->db->fetchColumnsIntoMap($sql, 'id', 'name');
  }


   
  /**
   * @return 
   *         
   */
  public function throwIfEmptyName($name)
  {
    $safeName = trim($name);
    if (tlStringLen($safeName) == 0)
    {
      $msg = "Class: " . __CLASS__ . " - " . "Method: " . __FUNCTION__ ;
      $msg .= " Empty name ";
      throw new Exception($msg);
    }
    return $safeName;
  }


  /**
   * 
    *
    */
  public function deleteByTestProject($tproject_id)
  {
    $sql = "DELETE FROM {$this->tables['platforms']} WHERE testproject_id = {$tproject_id}";
    $result = $this->db->exec_query($sql);
    
    return $result ? tl::OK : self::E_DBERROR;
  }


  /**
   *
   * @internal revisions
   * @since 1.9.4
   */
  public function testProjectCount($opt=null)
  {
    $debugMsg = '/* Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__ . '*/ ';
    $my['opt'] = array('range' => 'tproject');
    $my['opt'] = array_merge($my['opt'],(array)$opt);
    
    
    // HINT: COALESCE(COUNT(PLAT.id),0)
    //       allows to get 0 on platform_qty
    //
    $sql = $debugMsg . " SELECT COALESCE(COUNT(PLAT.id),0) AS platform_qty, TPROJ.id AS tproject_id " .
           " FROM {$this->tables['testprojects']} TPROJ " .
           " LEFT OUTER JOIN {$this->tables['platforms']} PLAT ON PLAT.testproject_id = TPROJ.id ";
    
    switch($my['opt']['range'])
    {
      case 'tproject':
        $sql .= " WHERE TPROJ.id = " . $this->tproject_id ;
      break;
    }
    $sql .= " GROUP BY TPROJ.id ";
    return ($this->db->fetchRowsIntoMap($sql,'tproject_id'));        
  }

  public function belongsToTestProject($id,$tproject_id = null)
  {
    $debugMsg = '/* Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__ . '*/ ';
    $pid = intval(is_null($tproject_id) ? $this->tproject_id : $tproject_id);
    
    $sql = " SELECT id FROM {$this->tables['platforms']} " .
           " WHERE id = " . intval($id) . " AND testproject_id=" . $pid;
    $dummy =  $this->db->fetchRowsIntoMap($sql,'id');
    return isset($dummy['id']);
  }  

  public function isLinkedToTestplan($id,$testplan_id)
  {
    $debugMsg = 'Class:' . __CLASS__ . ' - Method: ' . __FUNCTION__;
    $sql = " SELECT platform_id FROM {$this->tables['testplan_platforms']} " .
           " WHERE testplan_id = " . intval($testplan_id) .
           " AND platform_id = " . intval($id);
    $rs = $this->db->fetchRowsIntoMap($sql,'platform_id');
    return !is_null($rs);
  }
}
