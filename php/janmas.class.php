<?php
//----------------------------------------------------------//
//  janmas.class.php 
//  商品マスタ系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//  checkData()     CSVファイルのデータ整合性をチェック
//  setData()       CSVファイルをDBへ登録
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class JANMAS extends DB{
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
 public function checkData(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  //(入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  $this->items=CHKDATA(JANCSV,TB_JANMAS);//function.php内参照
  return true;
 }//checkData

 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setData(){
  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_JANMAS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_JANMAS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkData();             

  if(! $this->items["status"]) return false;

  //エラーフラグ
  $flg=0;

  //CSVのJANコード列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="jcode"){
    $jancol=$i;
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="JANコード列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if
  
  //データ登録
  try{
   $this->BeginTran();
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_JANMAS;
    $this->where="jcode=".$this->items["data"][$i][$jancol];
    $this->update();
   }//for
   $this->Commit();

   return true;
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
   throw $e;
  }//catch
 }//setData
}//JANMAS
?>
