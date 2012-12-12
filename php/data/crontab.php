#!/usr/bin/php 
<?php
//----------------------------------------------------------------//
// データインポート用クラス
// エクセルで作成したCSVファイルをDBへ取り込むプログラム。
// (新1階検品室 - 99その他 - ホームページ用 - ホームページ更新.xls)
//----------------------------------------------------------------//
//ファイル存在場所へ移動
$d=dirname(__FILE__);
chdir($d);

require_once("import.class.php");
try{
 //
 $log="自動更新プログラム　処理開始!!!";
 WRITELOG($log);

 //ファイルサーバーからファイルをコピー
 $cmd="scp kennpin1@172.16.0.12:/home/kennpin1/samba/dps/99その他/ホームページ用/*.csv ./";
 exec($cmd);

 //インスタンス生成
 $db=new ImportData();
//-------------------------------------------------------------//
 WriteLog("チラシタイトル更新");
 try{
  //データ更新
  $db->setTitle();

  //ログ書き込み
  WriteLog(TITLES,$db->items["data"]);

 }//try
 catch (Exception $e){
  WriteLog($e->getMessage());
  goto TIRASI_ITEM;
 }//catch

//-------------------------------------------------------------//
TIRASI_ITEM:
 WriteLog("チラシアイテム更新");
 try{
  //データ更新
  $db->setItem();

  //ログ書き込み
  WriteLog(ITEMS,$db->items["data"]);
 }//try
 catch (Exception $e){
  WriteLog($e->getMessage());
  goto CAL_ITEM;
 }//catch

//-------------------------------------------------------------//
CAL_ITEM:
 WriteLog("カレンダーアイテム更新");
 try{
  //データ更新
  $db->setCal();

  //ログ書き込み
  WriteLog(CAL,$db->items["data"]);
 }//try
 catch (Exception $e){
  WriteLog($e->getMessage());
  goto CAL_ITEM;
 }//catch

//-------------------------------------------------------------//
MAIL_ITEM:
 WriteLog("メールアイテム更新");
 try{
  //データ更新
  $db->setMailItem();

  //ログ書き込み
  WriteLog(MAILITEMS,$db->items["data"]);
 }//try
 catch (Exception $e){
  WriteLog($e->getMessage());
  goto PAGE_CONF;
 }//catch

//-------------------------------------------------------------//
PAGE_CONF:
 WriteLog("ページ詳細更新");
 try{
  //データ更新
  $db->setMailItem();

  //ログ書き込み
  WriteLog(PAGECONF,$db->items["data"]);
 }//try
 catch(Exception $e){
  WriteLog($e->getMessage());
 }//catch


}//try
catch(Exception $e){
 echo $e->getMessage();
 $log=$e->getMessage();
 WRITELOG($log);
}//catch

function WriteLog($log,$data=null){
 //ファイル名セット
 $path=LOGDIR.date("Ymd").".log";
 if(! file_exists($path)){
  $fp=fopen($path,"w");
 }//if
 else{
  $fp=fopen($path,"a");
 }//else

 //ファイル名なし、データなし
 if(! $data){
  $log=date("Y-m-d H:i:s")." ".$log."\n";
  fwrite($fp,$log);
 }//if

 if($data){
  //エラーデータ抽出
  foreach($data as $rownum=>$rowdata){
   if($rowdata["status"]) continue;
   $l=$log." ".($rownum+1)."行 ".$rowdata["err"];
   fwrite($fp,$l);
  }//foreach
 }//if

 fclose($fp);
}
?>
