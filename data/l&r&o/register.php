<?php
header("Content-Type:text/plain;charset=UTF-8");
$uname = $_REQUEST["uname"];
$upwd = $_REQUEST["upwd"];
$user_name = $_REQUEST["user_name"];
$email = $_REQUEST["email"];
$addr = $_REQUEST["addr"];
@$userIntro = $_REQUEST["userIntro"];
@$phone = $_REQUEST["phone"];
@$qq = $_REQUEST["qq"];
$registerTime = $_REQUEST["registerTime"];
require_once("../init.php");
$sql = "insert into ms_user values(
    null,
    '$uname',
    '$upwd',
    '$user_name',
    '$addr',
    '$userIntro',
    '$email',
    '$phone',
    '$qq',
    'img/cs.index/172_m.jpg',
    '$registerTime'
)";
$result = mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION["uid"] = mysqli_insert_id($conn);
    echo true;
}else{
    echo false;
}