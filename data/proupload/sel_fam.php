<?php
header("Content-Type:application/json;charset=UTF-8");
require_once("../init.php");
$sql = "select * from ms_pro_family";
echo json_encode(sql_execute($sql,MYSQLI_ASSOC));