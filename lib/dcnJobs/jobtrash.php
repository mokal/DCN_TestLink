<?php
header("Content-Type:text/html;charset=utf-8");
require_once("../../config.inc.php");
require_once("common.php");
testlinkInitPage($db,false,false,"checkRights");
$testproject_id = isset($_SESSION['testprojectID']) ? $_SESSION['testprojectID'] : 0;
$jobid = $_GET['id'];

if( is_null($_GET['confirm']) ){
    echo "<script>if(window.confirm('注意：只有因本地moni/dauto平台异常或手动退出后,才能将testlink上对应任务(异常任务)清理归档！')) location.href='jobtrash.php?id={$jobid}&confirm=yes';else location.href='jobtrash.php?id={$jobid}&confirm=no';</script>";  
}else{
    $confirm = $_GET['confirm'];
    if( $confirm == 'yes' ){
        $platform_mgr = new tlPlatform($db, $testproject_id);
        $result = $platform_mgr->jobtrash($jobid);
        if($result == 1){
            echo '<script type="text/javascript">window.alert("该任务成功归档至历史任务！");location.href="/lib/dcnJobs/jobsView.php";</script>';
        }else{
            echo '<script type="text/javascript">window.alert("归档失败，请检查后重试！");location.href="/lib/dcnJobs/jobsView.php";</script>';
        }
     }else{  
        echo '<script type="text/javascript">location.href="/lib/dcnJobs/jobsView.php";</script>';
     }
}
function checkRights(&$db,&$user)
{
	return True;
}

?>
