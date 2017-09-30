<?php
header("Content-Type:text/plain;charset=UTF-8");
require_once("../init.php");
@$uname=$_REQUEST["uname"];
if($uname){
  
  $sql="select * from ms_user where uname='$uname'";
  if(count(sql_execute($sql,MYSQLI_ASSOC))==0)
    echo "true";
  else
    echo "false";
}else{
  
  @$email=$_REQUEST["email"];
  $sql="select * from ms_user where email='$email'";
  if(count(sql_execute($sql,MYSQLI_ASSOC))==0)
    echo "true";
  else
    echo "false";
}