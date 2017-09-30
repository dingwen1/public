<?php
header("Content-Type:text/plain;charset=UTF-8");
$family_id = intval($_REQUEST["family_id"]);
$pname = $_REQUEST["pname"];
$info =$_REQUEST["info"];
$pic = $_REQUEST["pic"];
$issueTime = $_REQUEST["issueTime"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "INSERT INTO ms_pro VALUES(
  NULL,
  $family_id,
  '$pname',
  1,
  '$info',
  1,
  '$pic',
  $uid,
  '$issueTime'
)";


 
$result = mysqli_query($conn,$sql);
if($result){
  echo mysqli_insert_id($conn);
}else{
  echo false;
};