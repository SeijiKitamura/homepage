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

 //------------------------------------------------------//
 // CSV値チェックして配列へ格納する
 //------------------------------------------------------//
 public function checkData(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット(function.php)
  $this->items=GETARRAYCSV(MAILITEMSCSV,TB_MAILITEMS);

  return true;
 }//checkData

 //------------------------------------------------------//
 // CSVデータインポート
 //------------------------------------------------------//
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

 //------------------------------------------------------//
 // メール商品のLinリストを返す
 //------------------------------------------------------//
 public function getLinList($hiduke=null){
  if($hiduke && ! CHKDATE($hiduke)){
   throw new exception ($hiduke." 日付が不正です");
  }//if 
  
  if (! $hiduke) $hiduke=date("Y-m-d");

  //メンバリセット
  $this->items=null;
  $this->columns=null;

  //SQL生成
  $this->select="t2.lincode,t2.linname,count(t.jcode) as cnt";
  $this->from =TB_MAILITEMS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where=" hiduke='".$hiduke."'";
  $this->group=" t2.lincode,t2.linname";
  $this->order=" t2.lincode";

  //データセット
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["lincode"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["linname"]["local"];
  $this->items["local"][]="データ数";
 }//public function getLinList($hiduke=null){

 //------------------------------------------------------//
 // メール商品リストを返す(saletype 1:メール 2:おすすめ)
 //------------------------------------------------------//
 public function getItemList($saletype,$hiduke=null,$lincode=null,$clscode=null,$jcode=null){
  if($hiduke && ! CHKDATE($hiduke)){
   throw new exception ($hiduke." 日付が不正です");
  }//if 
  
  if (! $hiduke) $hiduke=date("Y-m-d");

  if(! is_numeric($saletype)){
   throw new exception($saletype." セールタイプが不正です");
  }//if

  //メンバリセット
  $this->items=null;
  $this->columns=null;

  //SQL生成
  $this->select =" t.hiduke,t.saletype";
  $this->select.=",t2.lincode,t2.linname";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t.jcode,t.maker";
  $this->select.=",t.sname,t.tani";
  $this->select.=",t.strprice,t.baika";
  $this->select.=",t.notice";
  $this->from =TB_MAILITEMS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =" t.hiduke='".$hiduke."'";
  $this->where.=" and t.saletype=".$saletype;
  if($lincode) $this->where.=" and t2.lincode=".$lincode; 
  if($clscode) $this->where.=" and t1.clscode=".$clscode; 
  if($jcode)   $this->where.=" and t.jcode=".$jcode; 
  $this->order="t2.lincode,t1.clscode,t.jcode";

  //データセット
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["lincode"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["linname"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_CLSMAS]["clscode"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_CLSMAS]["clsname"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["jcode"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["maker"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["sname"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["tani"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["strprice"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["baika"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_MAILITEMS]["notice"]["local"];

 }//public function getItemList($hiduke=null){
}//class
?>
