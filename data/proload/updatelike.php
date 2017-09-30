<?php
header("Content-Type:text/plain;charset=UTF-8");
$pid = $_REQUEST["pid"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");

$sql = "INSERT INTO ms_like VALUES(null,$pid,$uid)";
$res = mysqli_query($conn,$sql);
if($res){
    echo true;
}else{
    echo false;
}
?>