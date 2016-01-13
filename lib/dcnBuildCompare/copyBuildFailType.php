<?php
header("Content-Type:text/html;charset=utf-8");
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");
$testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
$oldexec = $_GET['oldexec'];
$newexec = $_GET['newexec'];

if( is_null($_GET['confirm']) ){
    echo "<script>if(window.confirm('注意：右侧版本2的分析结论将直接继承使用左侧版本1，请确认fail是同一个原因引起!!')) location.href='copyBuildFailType.php?oldexec={$oldexec}&newexec={$newexec}&confirm=yes';else location.href='copyBuildFailType.php?oldexec={$oldexec}&newexec={$newexec}&confirm=no';</script>";  
}else{
    $confirm = $_GET['confirm'];
    if( $confirm == 'yes' ){
    	$tplan_mgr = new testplan($db);
       // $platform_mgr = new tlPlatform($db, $testproject_id);
       // $result = $platform_mgr->jobtrash($jobid);
    	$result = $tplan_mgr->copyFailType($oldexec,$newexec);
        if($result == 1){
            echo '<script type="text/javascript">window.alert("复制分析结果成功！若完成所有分析工作，请点击左侧按钮刷新查看");</script>';
        }else{
            echo '<script type="text/javascript">window.alert("复制分析结果失败，请检查后重试！");</script>';
        }
     }else{  
        echo '<script type="text/javascript">window.alert("Canneled");</script>';
     }
}
function checkRights(&$db,&$user)
{
	return True;
}

?>
