<?php
header("Content-Type:text/plain;charset=UTF-8");
$user_name = $_REQUEST["user_name"];
$email = $_REQUEST["email"];
$addr = $_REQUEST["addr"];
$phone = $_REQUEST["phone"];
$qq = $_REQUEST["qq"];
$userIntro = $_REQUEST["userIntro"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "UPDATE ms_user 
    SET user_name='$user_name',email='$email',addr='$addr',phone='$phone',qq='$qq',userIntro='$userIntro'
     WHERE uid=$uid";
$result = mysqli_query($conn,$sql);
if($result){
  echo true;
}else{
  echo false;
}

?>