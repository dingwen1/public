<?php
header("Content-Type:application/json;charset=UTF-8");
$fam = $_REQUEST["fam"];
@$order = $_REQUEST["order"];
@$kw = $_REQUEST["kw"];
@$page = $_REQUEST["page"];

require_once("../init.php");
$output=[
    "pageSize"=>12,
    "currentPage"=>1,
    "totalPage"=>null,
    "dataNum"=>null,
    "data"=>null,
    "kw"=>$kw
];
if($page){$output["currentPage"]=$page;}

$famsql = "";
if($fam!=""){
    $famsql = " fname='$fam' ";
}

$kwsql = "";
if($kw!=""){
    $kwsql = " AND (pname like '%$kw%' or info like '%$kw%') ";
}
$sql = "SELECT count(*) FROM ms_pro,ms_pro_family 
        WHERE ".$famsql.$kwsql."AND ms_pro.family_id=ms_pro_family.fid" ;

$output["dataNum"] = sql_execute($sql)[0]["count(*)"];
$output["totalPage"] = ceil($output["dataNum"]/$output["pageSize"]);

$start = $output["pageSize"]*($output["currentPage"]-1);
$limitsql = " LIMIT $start,".$output["pageSize"] ;

$orderArr = [" pid DESC "," popNum DESC"," commNum DESC"," likeNum DESC"];
$ordersql  = " ORDER BY $orderArr[$order] ";

$sql = "SELECT pid,fname,pname,pic,issueTime,popNum,user_name,avatar,(SELECT count(*) FROM ms_like WHERE pro_id=pid) AS likeNum,(SELECT count(*) FROM ms_comment WHERE pro_id=pid) AS commNum 
        FROM ms_pro,ms_pro_family,ms_user 
        WHERE ".$famsql.$kwsql."AND ms_pro.family_id=ms_pro_family.fid AND ms_pro.user_id=ms_user.uid ".$ordersql.$limitsql;
$output["data"] = sql_execute($sql,MYSQLI_ASSOC);
echo json_encode($output);