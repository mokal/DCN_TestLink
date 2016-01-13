<?php
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");

$args = init_args();
$platform_mgr = new tlPlatform($db, $args->testproject_id);

$var_id = $_GET['varid'];
$suite_id = $_GET['suiteid'];
$all = $_GET['all'];
$verify = isset($_GET['verify']) ? $_GET['verify'] : 0 ;

$devices = $platform_mgr->getVarDevices($var_id,$suite_id);
$a = count($devices[0]);
echo "<p align='center'>共有<span style='color:red'>{$a}</span>款设备:<b>{$devices['all']}</b></p>" ;

if($a == 0){
	echo "<p align='center'><a href='viewVar.php?var_id={$var_id}&suite_id={$suite_id}'>返     回</a></p>";
}else{
	echo "<form name='form1' action='/lib/dcnVars/assign2AllPlan_delete.php?varid={$var_id}&suiteid={$suite_id}&all={$all}' method='post'>" ;
	echo "<table align='center'><tbody>";
	foreach($devices[0] as $device){
		$tplans = $platform_mgr->getDeviceTplan($device['id'],$all);
		foreach($tplans[0] as $nn=>$tplan){
			$needdelete[$device['id'].'-'.$tplan['id']] = $platform_mgr->modifyTplanCasesFromVar($tplan['id'],$device['id'],$var_id,$suite_id,$args->login_username,'add');
			if( $needdelete[$device['id'].'-'.$tplan['id']] != null ){
				echo "<tr><td align='center'>{$tplan['name']}-{$device['name']}:<input type='checkbox' id='{$tplan['id']}-{$device['id']}' name='{$tplan['id']}-{$device['id']}'></input></td></tr>";
			}
		}
	}
	$allneed = 0;
	foreach($needdelete as $tt){
		if($tt != null){
			$allneed++;
		}
	}
	if($allneed != 0){
		echo "<tr><td align='center'><input type='submit' value='确认删除以上勾选的 计划-设备 下的测试例'></input></td></tr>";
		echo "</tbody></table></form>";
		echo "<p align='center'><a href='viewVar.php?var_id={$var_id}&suite_id={$suite_id}'>不删除测试例返 回</a></p>";
	}else{
		echo "</form></p><p align='center'><a href='viewVar.php?var_id={$var_id}&suite_id={$suite_id}'>返      回</a></p>";
	}

	$dindex = 1;
	foreach($devices[0] as $device){
		if($all==1){
			echo "<p align='center'><b>step2.{$dindex}:</b>开始搜索覆盖了设备<span style='color:red'>{$device['name']}</span>的测试计划...</p>" ;
		}elseif($all==0){
			echo "<p align='center'><b>step2.{$dindex}:</b>开始搜索覆盖了设备<span style='color:red'>{$device['name']}</span>的测试计划(排除售后)...</p>" ;
		}
		$tplans = $platform_mgr->getDeviceTplan($device['id'],$all);
		$a = count($tplans[0]);
		echo "<p align='center'>搜索到<span style='color:red'>{$a}</span>个测试计划<b>{$tplans['all']}</b></p>";
		$tindex = 1;

		foreach($tplans[0] as $nn=>$tplan){
			echo "<p align='center'><b>step3.{$tindex}.</b>更新测试计划<span style='color:red'>{$tplan['name']}</span>的测试例...</p>";
			if( $needdelete[$device['id'].'-'.$tplan['id']] == null ){
				echo "<p align='center'><span style='color:red'>测试计划{$tplan['name']}</span>中需要<span style='color:red'>添加</span>的测试例维护完毕!没有需删除的测试例。</p>";
			}else{
				$total = count($needdelete[$device['id'].'-'.$tplan['id']]);
				echo "<p align='center'><span style='color:red'>测试计划{$tplan['name']}</span>中需要<span style='color:red'>添加</span>的测试例维护完毕!请确认如下{$total}个测试例可被删除:</p>";
				$temp = " <p align='center'><table cellpadding='2' cellspacing='0' align='center' border='2' bordercolor='#000000'><tr>";

				$tcvindex = 1;
				foreach($needdelete[$device['id'].'-'.$tplan['id']] as $tcvid){
					$casename = $platform_mgr->getCaseNamebyTCVid($tcvid) ;
					if( $tcvindex % 5 == 0 ){
						$temp .= " </tr><tr><td align='center'>{$casename}</td> ";
					}else{
						$temp .= " <td align='center'>{$casename}</td>";
					}
					$tcvindex++;
				}
				$temp .= " </tr></table></p> ";
				echo $temp;
			}
			$tindex++;
		}
		$dindex++ ;
		echo "<br>";
	}
}

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