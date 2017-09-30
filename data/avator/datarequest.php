<?php
header("Content-Type:application/json;charset=UTF-8");
$akw = $_REQUEST["akw"];
@$page = $_REQUEST["page"];
require_once("../init.php");
$output=[
  "pageSize"=>18,
  "currentPage"=>1,
  "totalPage"=>null,//总页数
  "dataNum"=>null,//总数据量
  "data"=>null,//shuju 
];
if($page){$output["currentPage"]=$page;}

$akwsql = "";
if($akw!=""){
  $akwsql = " WHERE user_name like '%$akw%' OR addr like '%$akw%' OR userIntro like '%$akw%' OR phone like '%$akw%' OR qq like '%$akw%'  ";
}
$sql = "SELECT count(*)  
        FROM ms_user ".$akwsql;
$output["dataNum"] = sql_execute($sql)[0]["count(*)"];
$output["totalPage"] = ceil($output["dataNum"]/$output["pageSize"]);
$start = $output["pageSize"]*($output["currentPage"]-1);

$sql = "SELECT uid,user_name,addr,avatar,(SELECT count(*) FROM ms_pro WHERE user_id=uid) AS proNum 
        FROM ms_user ".$akwsql." 
        ORDER BY proNum DESC 
        LIMIT $start,".$output["pageSize"];
$output["data"] = sql_execute($sql,MYSQLI_ASSOC);
echo json_encode($output);