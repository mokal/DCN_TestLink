<?php
$mysqli = new mysqli("localhost","testlink","testlink","testlink");
$mysqli->set_charset("utf8");

if( !isset($_GET['id']) ){
    echo "<script>alert('Error access!!!');</script>" ;
    $mysqli->close() ;
    exit();
}else{
    $id = $_GET['id'];


    if( isset($_GET['fail']) ){
         $failtype = $_GET['fail'];

         $query = " UPDATE executions SET fail_type = '{$failtype}' WHERE id = {$id} " ;
         $mysqli->query($query);

         $query = " UPDATE job_testcase SET fail_type = '{$failtype}' WHERE exe_id={$id} " ;
         $mysqli->query($query);
     }

    if( isset($_GET['note']) ){

         $note = $_GET['note'];

         $query = " UPDATE executions SET notes = '{$note}' WHERE id = {$id} " ;
         $mysqli->query($query);
     }
    $mysqli->close() ;
}

?>