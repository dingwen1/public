<?php
header("Content-Type:application/json;charset=UTF-8");
$output=[
  "errno"=>0,
  "data"=>null
];
if(!empty($_FILES["img"])){
  $picname = $_FILES["img"]["name"];
  $picsize = $_FILES["img"]["size"]; 
  if($picsize>3*1024*1024){
    $output["error"]=1;
  }
  $type = strstr($picname,".");
  if($type!=".jpg"&&$type!=".png"&&$type!=".gif"){
    $output["errno"]=2;
  }
  $pics = time().rand(1,9999).$type;
  move_uploaded_file($_FILES["img"]["tmp_name"],"../../img/userimg/".$pics);
  $output["data"]=["img/userimg/".$pics]; 
}
echo json_encode($output);