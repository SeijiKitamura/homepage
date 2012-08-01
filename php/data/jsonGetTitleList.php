<?php
//------------------------------------------------------------//
// チラシタイトルリストを返す
// 返り値:json["data"]     tirasi_id,hiduke,title,view_start,view_end
//       :json["local"]    上記列の日本語名
//       :json["status"]   true false
//------------------------------------------------------------//
require_once("../tirasi.class.php");
try{
 //引数チェック

 //データゲット
 $db=new TIRASI();
 $db->getTitleList();

 echo "<pre>";
 print_r($db->items);

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
