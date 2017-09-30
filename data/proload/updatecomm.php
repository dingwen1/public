<?php
header("Content-Type:text/plain;charset=UTF-8");
$pid = $_REQUEST["pid"];
$comment = $_REQUEST["comment"];
$commTime = $_REQUEST["commTime"];
session_start();
$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "INSERT INTO ms_comment VALUES(NULL,$pid,$uid,'$comment','$commTime')";
$res = mysqli_query($conn,$sql);
if($res){
    echo true;
}else{
    echo false;
}