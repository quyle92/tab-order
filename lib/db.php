<?php
$serverName = "DELL-PC\SQLEXPRESS";
$connectionInfo = array( "Database"=>"NH_STEAK_PIZZA","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>