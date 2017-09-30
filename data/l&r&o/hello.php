<?php
header("Content-Type:application/javascript;charset=UTF-8");
session_start();
$uid=$_SESSION["uid"];
if($uid){
  require_once("../init.php");
  $sql="select user_name from ms_user where uid=$uid";
  $uname=sql_execute($sql)[0]["user_name"];
  echo '$("#loginbox").html(`Welcome!  <a href="usermessage.html" class="redfont">'.$uname.'</a>[<a href="#" id="loginout">登出</a>]`);
        $("#loginout").click((e)=>{ e.preventDefault();loginout()});
        localStorage.logincode = 1;';
}else{
  echo 'localStorage.logincode = 0';
}
?>