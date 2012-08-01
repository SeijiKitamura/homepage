<?php
//------------------------------------------------------------//
// チラシリストを返す
// 返り値:json["data"]     tirasi_id,lincode,jcode,sname,maker,tani,baika
//       :json["local"]    上記列の日本語名
//       :json["status"]   true false
//------------------------------------------------------------//
require_once("../tirasi.class.php");
try{
 //引数チェック
 if(! is_numeric($_GET["tirasi_id"])){
   throw new exception("チラシ番号が正しくありません");
 }//if
 $tirasi_id=$_GET["tirasi_id"];

 //データゲット
 $db=new TIRASI();
 $db->getImageList($tirasi_id);
 
 //JSON形式で表示
 echo json_encode($db->items);
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
