<?php
header("Content-Type:application/json;charset=UTF-8");
$uid = $_REQUEST["uid"];
require_once("../init.php");
$output = [
  "usermsg" => null,
  "promsg" => null
];
$sql = "SELECT uid,user_name,addr,userIntro,avatar 
        FROM ms_user 
        WHERE uid=$uid";
$output["usermsg"] = sql_execute($sql,MYSQLI_ASSOC);
$sql = "SELECT pid,fname,pname,pic,issueTime,popNum,user_name,avatar,(SELECT count(*) FROM ms_like WHERE pro_id=pid) AS likeNum,(SELECT count(*) FROM ms_comment WHERE pro_id=pid) AS commNum 
        FROM ms_pro,ms_pro_family,ms_user 
        WHERE ms_pro.family_id=ms_pro_family.fid AND ms_pro.user_id=ms_user.uid AND ms_pro.user_id=$uid";

$output["promsg"] = sql_execute($sql,MYSQLI_ASSOC);
echo json_encode($output);