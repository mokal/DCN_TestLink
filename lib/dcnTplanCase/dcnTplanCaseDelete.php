<?php
$mysqli = new mysqli("192.168.50.192","testlink","Eqp9qH9Pya9FMVyV","testlink");
$mysqli->set_charset("utf8");


$tplan_id = $_GET['tplan_id'];
$device_id = $_GET['device_id'];
$tcv_id = $_GET['tcv_id'];

$query = " DELETE FROM testplan_tcversions WHERE testplan_id = {$tplan_id} AND platform_id = {$device_id} AND tcversion_id = {$tcv_id} " ;
$mysqli->query($query);

$mysqli->close() ;

echo "<br>";

echo "<h1 align='center'>Delete Success!</h1>" ;

?>