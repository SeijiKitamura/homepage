<?php
//----------------------------------------------------------//
//  calendar.class.php 
//  カレンダー系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//  checkData()     CSVファイルのデータ整合性をチェック
//  setData()       CSVファイルをDBへ登録
//----------------------------------------------------------//

require_once("db.class.php");
require_once("function.php");

class CL extends DB{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報

 function __construct(){
  parent::__construct();

  $this->columns=$GLOBALS["TABLES"][TB_CAL];
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_CAL];
  if(! $this->columns){
   throw new exception("テーブル情報がありません。設定を見なおしてください。config TABLES");
  }
  if(! $this->csvcol){
   throw new exception("CSV列情報がありません。設定を見なおしてください。config CSVCOLUMNS");
  }
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

  //CSVファイルを配列へ格納
  $this->items=CHKDATA(CALCSV,TB_CAL);//function.php内参照

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
  //データ初期化
  $this->items=null;

  //CSVファイルを配列へ格納
  $this->checkData();
  
  //エラーチェック
  if(! $this->items["status"]) return false;

  //エラーフラグ
  $flg=0;

  //CSVの日付列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="hiduke"){
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="日付列がありません。設定を見なおしてください。config CSVCOLUMNS";
   throw new exception($msg);
  }//if

  //CSV最初のデータの日付をゲット
  $hiduke=$this->items["data"][0][$i];

  //データ登録
  try{
   //トランザクション開始
   $this->BeginTran();

   //hiduke以降の既存データを削除
   $this->from=TB_CAL;
   $this->where="hiduke >='".$hiduke."'";
   $this->delete();

   //CSVデータ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }
    $this->from=TB_CAL;
    $this->where="id=0"; //無条件追加
    $this->update();
   }//for i

   //コミット
   $this->Commit();

   return true;
  }//try
  catch(Exception $e){
   $this->items["status"]=false;

   //ロールバック
   $this->RollBack();

   throw $e;
  }//catch
 }// setData
}// CL

?>
