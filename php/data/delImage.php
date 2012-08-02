<?php
//------------------------------------------------------------//
// 指定された画像を削除する
// 返り値: json["status"]
//------------------------------------------------------------// 

require_once("../config.php");

//引数チェック
try{
 //引数チェック
 if(! $_GET["jcode"] || ! is_numeric($_GET["jcode"])){
  throw new exception("JANコードが正しくありません");
 }//if
 $jcode=$_GET["jcode"];

 //ファイル削除
 $filename=IMGDIR.$jcode.".jpg";

 if(file_exists($filename)){
  if(! unlink($filename)){
   throw new exception("ファイル削除に失敗しました");
  }//if
 }//if
 else{
  throw new exception("ファイルが存在しません");
 }//else

 return true;
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
