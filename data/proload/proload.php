<?php
header("Content-Type:application/json;charset=UTF-8");
$pid = $_REQUEST["pid"];
session_start();
@$uid = $_SESSION["uid"];
require_once("../init.php");
$sql = "SELECT popNum FROM ms_pro WHERE pid=$pid";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($res);
$popNum = $row[0]+1;
$sql = "UPDATE ms_pro SET popNum=$popNum WHERE pid=$pid";
mysqli_query($conn,$sql);

#开始加载页面也所需要的数据
$output=[
    "pro"=>null,
    "comm"=>null,
    "islike"=>false
];
$sql = "SELECT pid,fname,pname,info,pic,uid,avatar,user_name,issueTime,popNum,(SELECT count(*) FROM ms_like WHERE pro_id=pid) AS likeNum,(SELECT count(*) FROM ms_comment WHERE pro_id=pid) AS commNum 
        FROM ms_pro,ms_pro_family,ms_user
        WHERE ms_pro.family_id=ms_pro_family.fid AND ms_pro.user_id=ms_user.uid AND ms_pro.pid=$pid";
$output["pro"] = sql_execute($sql,MYSQLI_ASSOC);

$sql = "SELECT cid,uid,avatar,user_name,comment,commTime 
        FROM ms_comment,ms_user 
        WHERE ms_comment.user_id=ms_user.uid AND ms_comment.pro_id=$pid 
        ORDER BY cid DESC";
$output["comm"] = sql_execute($sql,MYSQLI_ASSOC);

if($uid){
    $sql = "SELECT * FROM ms_like WHERE pro_id=$pid AND user_id=$uid";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_row($res);
    if($row){
        $output["islike"] = true;
    }
}
echo json_encode($output);