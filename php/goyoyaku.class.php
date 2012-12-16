<?php
//----------------------------------------------------------//
//  goyoyaku.class.php 
//  ご予約商品系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
//  getLinList()         ご予約商品のラインリストを返す
//  getClsList($lincode) 指定ラインのクラスリストを返す
//  getGrpList()         ご予約商品のグループリストを返す
//  getItemList()        商品リストを返す
//  getLinItem($lincode) 指定ラインの商品リストを返す
//  getClsItem($clscode) 指定クラスの商品リストを返す
//  getGrpItem($group)   指定グループの商品リストを返す
//  getJanItem($jcode)   指定商品を返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class GOYOYAKU extends DB{
 public $items;       //データを格納
 protected $saletype; //セールタイプ番号
 protected $andwhere; //where句

 function __construct(){
  parent::__construct();
  $this->saletype=5;   //config.php $SALETYPE
 }// function __construct(){

 //ベースとなるwhere句
 protected function setwhere(){
  $this->andwhere =" saletype='".$this->saletype."'";
 }

//----------------------------------------------------------//
// ご予約商品のラインリストを返す
//----------------------------------------------------------//
 public function getLinList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t2.lincode,t2.linname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =" (select clscode,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode,jcode";
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->group =" t2.lincode,t2.linname";
  $this->order =" t2.lincode";
  $this->items["data"]=$this->getArray();
 
 }// public function getLinList(){

//----------------------------------------------------------//
// ご予約商品指定ラインのクラスリストを返す
//----------------------------------------------------------//
  public function getClsList($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t1.clscode,t1.clsname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =" (select clscode,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode,jcode";
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where=" t2.lincode=".$lincode;
  $this->group =" t1.clscode,t1.clsname";
  $this->order =" t1.clscode";
  $this->items["data"]=$this->getArray();
 }//public function getClsList(){

//----------------------------------------------------------//
// ご予約商品のグループリストを返す
//----------------------------------------------------------//
  public function getGrpList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.flg0 as grpcode,t.flg1 as grpname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =TB_SALEITEMS." as t ";
  $this->where=$this->andwhere;
  $this->group =" t.flg0,t.flg1";
  $this->order =" t.flg0";
  $this->items["data"]=$this->getArray();
 }//public function getGrpList(){

//----------------------------------------------------------//
// ご予約商品すべてのアイテムリストを返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.flg0 as grpcode,t.flg1 as grpname ,t.flg2 as datanum";
  $this->select.=",t.clscode,t.jcode,t.sname";
  $this->select.=",t.tani,t.price,t.notice,t.saletype";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_SALEITEMS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->order =" t.flg0,t.flg2";
  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
//商品一覧から特定ラインの商品を抽出
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
//商品一覧から特定クラスの商品を抽出
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
//商品一覧から特定グループの商品を抽出
//----------------------------------------------------------//
 public function getGrpItem($grp){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["grpcode"]==$grp){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getClsItem($clscode){


//----------------------------------------------------------//
//商品一覧から特定商品を抽出
//----------------------------------------------------------//
 public function getJanItem($jcode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["jcode"]==$jcode){
    $item[]=$rowdata;
    break;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getJanItem($jcode){
}//class GOYOYAKU extends DB{
?>
