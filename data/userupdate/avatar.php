<?php
#头像的上传
header("Content-Type:text/plain;charset=UTF-8");
$avatar = $_REQUEST["avatar"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "UPDATE ms_user SET avatar='$avatar' WHERE uid=$uid";
$result = mysqli_query($conn,$sql);
if($result){
  echo true;
}else{
  echo false;
}



?>