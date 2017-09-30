<?php
header("Content-Type:application/javascript;charset=UTF-8");
session_start();
@$uid = c;
if($uid){
    $_SESSION["uid"]=null;
    echo 'location=window.location';
}