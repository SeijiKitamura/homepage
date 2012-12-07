<?php
//----------------------------------------------------------//
//  calendar.class.php 
//  カレンダー系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
//  getLinList()         指定月のラインリストを返す
//  getClsList()         指定月、指定ラインのクラスリストを返す
//  getItemList()        指定月のカレンダー情報を返す
//  getLinItem($lincode) 指定月、指定ラインのカレンダー情報を返す
//  getClsItem($clscode) 指定月、指定クラスのカレンダー情報を返す
//  getCalendar()        指定日のカレンダー情報を返す
//  getMonthCount()      指定月に何回カレンダー情報があるかを返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class CL extends DB{
 public $items;   //データを格納
 public $saleday; //表示したい日(この日付以降が表示される）

 protected $saletype;//セールタイプ番号
 protected $andwhere;//where句
 
 function __construct(){
  parent::__construct();

  //表示したい日
  $this->saleday=date("Y-m-d");
  
  //セールタイプ番号ゲット
  $this->saletype=3;

 }//__construct
 
 protected function setwhere(){
  $uk=strtotime($this->saleday);
  $sday=date("Y-m-1",$uk);
  $eday=date("Y-m-d",mktime(0,0,0,(date("m",$uk)+1),0,date("Y",$uk)));
  $this->andwhere =" saleday between '".$sday."' and '".$eday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
 }

//----------------------------------------------------------//
// 指定月のラインリストを返す
// (cntは指定月に何回特売があるかを示す）
//----------------------------------------------------------//
 public function getLinList(){
  $this->items=null;

  $this->setwhere();

  $this->select ="t3.lincode,t3.linname,count(t3.saleday) as cnt";
  $this->from =" (select t2.lincode,t2.linname,t.saleday from ";
  $this->from.=" (select saleday,clscode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->from.=" group by t2.lincode,t2.linname,t.saleday ) as t3";
  $this->group =" t3.lincode,t3.linname";
  $this->order =" t3.lincode";
  $this->items["data"]=$this->getArray();
 }//public function getLinList(){

//----------------------------------------------------------//
// 指定月、指定ラインのクラスリストを返す
// (cntはそのクラスに何アイテムあるかを示す）
//----------------------------------------------------------//
 public function getClsList($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t2.clscode,t2.clsname,t1.cnt ";
  $this->from =" (select clscode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode ";
  $this->from.=" ) as t";
  $this->from.=" inner join ";
  $this->from.=" (select clscode,count(jcode) as cnt from ".TB_JANMAS;
  $this->from.="  group by clscode) as t1 on ";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode ";
  $this->from.=" inner join ".TB_LINMAS." as t3 on";
  $this->from.=" t2.lincode=t3.lincode";
  $this->where=" t2.lincode=".$lincode;
  $this->order =" t1.clscode";
  $this->items["data"]=$this->getArray();

 }//public function getClsList(){

//----------------------------------------------------------//
// 指定月のカレンダー情報を返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.saleday,t.clscode,t.sname";
  $this->select.=",t.tani,t.price,t.notice";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =" (select * from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->order =" t.saleday,t.clscode";

  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
//指定月の特定ラインの商品を抽出
//----------------------------------------------------------//
 public function getLinItem($lincode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["lincode"]==$lincode){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function LinItem($lincode){

//----------------------------------------------------------//
//指定月の特定クラスの商品を抽出
//----------------------------------------------------------//
 public function getClsItem($clscode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["clscode"]==$clscode){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getClsItem($clscode){

//----------------------------------------------------------//
//指定日の商品を抽出
//----------------------------------------------------------//
 public function getCalendar(){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($rowdata["saleday"])==strtotime($this->saleday)){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getClsItem($clscode){


//----------------------------------------------------------//
//指定月に何回カレンダー情報があるかを返す
//----------------------------------------------------------//
 public function getMonthCount(){
  $this->items=null;

  //データゲット
  $this->getItemList();

  $saleday=0;
  $cnt=0;
  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($saleday)!==strtotime($rowdata["saleday"])){
    $cnt++;
   }//if
   $saleday=$rowdata["saleday"];
  }//foreach

  $this->items=$cnt;
 }//public function getMonthCount(){
}//TIRASI

?>
