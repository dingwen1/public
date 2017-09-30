<?php
header("Content-Type:text/plain;charset=UTF-8");
$uname = $_REQUEST["uname"];
$upwd = $_REQUEST["upwd"];
require_once("../init.php");
$sql = "select uid from ms_user where uname='$uname' and upwd='$upwd'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
if($row){
    session_start();
    $_SESSION["uid"] = $row[0];
    echo 1;
}else{
    echo 0;
};