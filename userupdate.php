<?php
require_once("./php/auth.class.php");
try{
 //$_POSTでお客様情報を受け取る
 if(! $_POST){
  throw new exception("登録画面にてお客様情報を登録してください");
 }
 $user=$_POST;
 $db=new AUTH();
 $db->UserAdd($user);

 echo json_encode($db->items);
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
