<?php
header("Content-Type:text/plain;charset=UTF-8");
$oldpwd = $_REQUEST["oldpwd"];
$newpwd = $_REQUEST["newpwd"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "SELECT uid FROM ms_user WHERE uid=$uid AND upwd='$oldpwd'";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($res);
if($row==null){
    echo false;
}else{
    $sql = "UPDATE ms_user SET upwd='$newpwd' WHERE uid=$uid";
    mysqli_query($conn,$sql);
    echo true;
}