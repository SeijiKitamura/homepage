<?php
//----------------------------------------------------------//
//  tirasi.class.php 
//  広告系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//  checkData()     CSVファイルのデータ整合性をチェック
//  setData()       CSVファイルをDBへ登録
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class TIRASI extends DB{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報

 function __construct(){
  parent::__construct();
 }//__construct


 //---------------------------------------------------------//
 // CSVファイルの整合性をチェック
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function checkDataTitle(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  //(入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  $this->items=CHKDATA(TITLECSV,TB_TITLES);//function.php内参照
  
  return true;
 }// checkDataTitle
 
 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataTitle(){
  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_TITLES];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_TITLES];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkDataTitle();
  if(! $this->items["status"]) return false;
   
  //エラーフラグ
  $flg=0;

  //CSVのチラシ番号列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="tirasi_id"){
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="チラシ番号列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if

  //CSVのチラシ投函日をゲット
  $hiduke=$this->items["data"][0][$i];

  try{
   //トランザクション開始
   $this->BeginTran();

   //既存データ削除
   $this->from=TB_TITLES;
   $this->where="hiduke>='".$hiduke."'";
   $this->delete();
   

   //CSVデータ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_TITLES;
    $this->where="tirasi_id=0";//無条件追加
    $this->update();
   }//for

   //コミット
   $this->Commit();

   return true;

  }//try
  catch(Exception $e){
   $this->items["status"]=false;
   $this->RollBack();
   throw $e;
  }//catch
 }// setDataTitle

 //---------------------------------------------------------//
 // CSVファイルの整合性をチェック
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function checkDataItem(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->items["data"]=CHKDATA(ITEMCSV,TB_ITEMS);//function.php内参照
  
  return true;
 }// checkDataITEM

 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataItem(){
 //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_ITEMS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_ITEMS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->items=CHKDATA(ITEMCSV,TB_ITEMS);//function.php内参照
  if(! $this->items["status"]) return false;

  //エラーフラグ
  $flg=0;

  //CSVのチラシ番号列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="tirasi_id"){
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="チラシ番号列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if

  //CSVのチラシ番号リストを作成
  $colnum=$i;
  for($i=0;$i<count($this->items["data"]);$i++){
   if($t!=$this->items["data"][$i][$colnum]){
    $tirasi_id[]=$this->items["data"][$i][$colnum];
    $t=$this->items["data"][$i][$colnum];
   }//if
  }//for

  try{
   //トランザクション開始
   $this->BeginTran();

   //既存データ削除
   for($i=0;$i<count($tirasi_id);$i++){
    $this->from=TB_ITEMS;
    $this->where="tirasi_id=".$tirasi_id[$i];
    $this->delete();
   }
   

   //CSVデータ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_ITEMS;
    $this->where="tirasi_id=0";//無条件追加
    $this->update();
   }//for

   //コミット
   $this->Commit();

   return true;

  }//try
  catch(Exception $e){
   $this->items["status"]=false;
   $this->RollBack();
   throw $e;
  }//catch
 }//setDataItem
 
}//TIRASI

?>
