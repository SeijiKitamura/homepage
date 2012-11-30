#!/usr/bin/php 
<?php
//ファイル存在場所へ移動
$d=dirname(__FILE__);
chdir($d);

require_once("../config.php");
require_once("../tirasi.class.php");
require_once("../calendar.class.php");
require_once("../maillist.class.php");
try{
 //
 $log="自動更新プログラム　処理開始!!!";
 WRITELOG($log);

 //ファイルサーバーからファイルをコピー
 $cmd="scp kennpin1@172.16.0.12:/home/kennpin1/samba/dps/99その他/ホームページ用/*.csv ./";
 exec($cmd);

//-------------------------------------------------------------//
MAILDATA:
$log="mailitem.csv 更新処理開始";
WRITELOG($log);
 $db=new MAILLIST();

 //ファイル存在をチェック
 if(! file_exists(MAILITEMSCSV)){
  $log=MAILITEMSCSV."がありません";
  WRITELOG($log);
  goto CALENDAR;
 }//if

 $db->setData();

 //エラーデータ抽出
 foreach($db->items["data"] as $row=>$val){
  if($val["err"]!=="OK"){
   $log =MAILITEMSCSV." ".($row+1)."行 ";
   $log.=$val["err"];
   WRITELOG($log);
  }//if
 }//foreach

 //-------------------------------------------------------------//
CALENDAR:
$log="calendar.csv 更新処理開始";
WRITELOG($log);
 $db=new CL();

 //ファイル存在チェック
 if(! file_exists(CALCSV)){
  //throw new exception(ITEMCSV."がありません");
  $log=CALCSV."がありません";
  WRITELOG($log);
  goto TIRAITITLE;
 }//if
  
 $db->setData();

 //エラーデータ抽出
 foreach($db->items["data"] as $row=>$val){
  if($val["err"]!=="OK"){
   $log =CALCSV." ".($row+1)."行 ";
   $log.=$val["hiduke"]." ".$val["err"];
   WRITELOG($log);
  }//if
 }//foreach

//-------------------------------------------------------------//
TIRAITITLE:
$log="tirasititle.csv 更新処理開始";
WRITELOG($log);

 $db=new TIRASI();
 //ファイル存在チェック
 if(! file_exists(TITLECSV)){
  //throw new exception(ITEMCSV."がありません");
  $log=TITLECSV."がありません";
  WRITELOG($log);
  goto TIRASIITEM;
 }//if
 
 //CSVをDBへ格納
 $db->setDataTitle();

 //エラーデータ抽出
 foreach($db->items["data"] as $row=>$val){
  if($val["err"]!=="OK"){
   $log =ITEMCSV." ".($row+1)."行 ";
   $log.=$val["hiduke"]." ".$val["jcode"]." ".$val["err"];
   WRITELOG($log);
  }//if
 }//foreach

//-------------------------------------------------------------//
TIRASIITEM:
$log="tirasiitem.csv 更新処理開始";
WRITELOG($log);

 $db=new TIRASI();
 //ファイル存在チェック
 if(! file_exists(ITEMCSV)){
  //throw new exception(ITEMCSV."がありません");
  $log=ITEMCSV."がありません";
  WRITELOG($log);
  //goto NEXT;
 }//if
 
 //CSVをDBへ格納
 $db->setDataItem();

 //エラーデータ抽出
 foreach($db->items["data"] as $row=>$val){
  if($val["err"]!=="OK"){
   $log =ITEMCSV." ".($row+1)."行 ";
   $log.=$val["hiduke"]." ".$val["jcode"]." ".$val["err"];
   WRITELOG($log);
  }//if
 }//foreach

//-------------------------------------------------------------//
//メール更新(ここから)
}//try
catch(Exception $e){
 echo $e->getMessage();
 $log=$e->getMessage();
 WRITELOG($log);
}//catch

function WRITELOG($log){
 //ファイル名セット
 $path=LOGDIR.date("Ymd").".log";
 if(! file_exists($path)){
  $fp=fopen($path,"w");
 }//if
 else{
  $fp=fopen($path,"a");
 }//else

 $log=date("Y-m-d H:i:s")." ".$log."\n";
 fwrite($fp,$log);

 fclose($fp);
}
?>
