<?php
header("Content-Type:application/json;charset=UTF-8");
require_once("../init.php");
$output = [
    "pro"=>null,
    "ao"=>null,
    "sl"=>null,
    "newmsg"=>null
];
$sql = "SELECT pid,fname,pname,pic,issueTime,popNum,user_name,avatar,(SELECT count(*) FROM ms_like WHERE pro_id=pid) AS likeNum,(SELECT count(*) FROM ms_comment WHERE pro_id=pid) AS commNum 
        FROM ms_pro,ms_pro_family,ms_user 
        WHERE ms_pro.family_id=ms_pro_family.fid AND ms_pro.user_id=ms_user.uid AND ms_pro.family_id<8 
        ORDER BY pid DESC 
        LIMIT 0,15";
$output["pro"] =  sql_execute($sql,MYSQLI_ASSOC);

$sql = "SELECT uid,user_name,addr,avatar,(SELECT count(*) FROM ms_pro WHERE user_id=uid) AS proNum 
        FROM ms_user 
        ORDER BY proNum DESC 
        LIMIT 0,15";
$output["ao"] = sql_execute($sql,MYSQLI_ASSOC);

$sql = "SELECT pid,pname,issueTime 
        FROM ms_pro 
        WHERE family_id>7 
        ORDER BY pid DESC 
        LIMIT 0,14 ";
$output["sl"] = sql_execute($sql,MYSQLI_ASSOC);

$sql = "SELECT pid,pname,uid,user_name,commTime  
        FROM ms_comment,ms_user,ms_pro 
        WHERE ms_comment.pro_id=ms_pro.pid AND ms_comment.user_id=ms_user.uid 
        ORDER BY cid DESC 
        LIMIT 0,1";
$output["newmsg"] = sql_execute($sql,MYSQLI_ASSOC);
echo json_encode($output);
