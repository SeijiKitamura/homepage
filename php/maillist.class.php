<?php
require_once("db.class.php");
require_once("function.php");

class MAILLIST extends db{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報

 function __construct(){
  parent::__construct();

  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_MAILITEMS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見なおしてください";
   throw new exception($msg);
  }//if

  //CSV列情報をゲット
  $this->csvcol=$GLOBALS["CSVCOLUMNS"][TB_MAILITEMS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見なおしてください";
   throw new exception($msg);
  }//if
 }//__construct

 public function checkData(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット(function.php)
  $this->items=GETARRAYCSV(MAILITEMSCSV,TB_MAILITEMS);

  return true;
 }//checkData

 public function setData(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkData();

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");

  try{
   $this->BeginTran();

   //既存データを削除
   $hiduke="";
   foreach($this->items["data"] as $rownum=>$row){
    if ($row["hiduke"]!==$hiduke){
     $this->from=TB_MAILITEMS;
     $this->where="hiduke='".$row["hiduke"]."'";
     $this->delete();
    }//if
    $hiduke=$row["hiduke"];
   }//foreach

   //SQL生成(エラーデータを除く)
   foreach ($this->items["data"] as $rownum=>$row){
    //エラーチェック
    if($row["err"]!=="OK"){
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }//if

    foreach($this->csvcol as $colnum=>$colname){
     $this->updatecol[$colname]=$this->items["data"][$rownum][$colname];
    }//foreach
    $this->from=TB_MAILITEMS;
    $this->where="id=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->items["status"]=false;
   $this->RollBack();
   throw $e;
  }//catch
 }//setData
}//class
?>
