<?php
//----------------------------------------------------------//
//  janmas.class.php 
//  商品マスタ系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//  checkData()     CSVファイルのデータ整合性をチェック
//  setData()       CSVファイルをDBへ登録
//  getLinItems()   同一ラインの商品を配列で返す
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

  //if(! $this->items["status"]) return false;

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
    //エラーデータチェック
    if($this->items["data"][$i]["err"]!="OK"){
     $this->items["errdata"][$i]=$this->items["data"][$i];
     continue;
    }
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

 //---------------------------------------------------------//
 // 同一クラスの商品マスタを返す(引数$jcodeは除く)
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getClsItems($jcode){
  //引数チェック
  if(! is_numeric($jcode)|| ! $jcode){
   throw new exception("JANコードが不正です");
  }

  //メンバーリセット
  $this->items=null;

  //テーブル情報ゲット
  $janmas=$GLOBALS["TABLES"][TB_JANMAS];

  //lincodeをゲット
  $this->select="t.clscode";
  $this->from =TB_JANMAS." as t";
  $this->where=" t.jcode=".$jcode;
  if(! $this->items["data"]=$this->getArray()){
   $this->items["status"]=false;
   $this->items["data"]="JANコードがありません。";
   return false;
  }
  $clscode=$this->ary[0]["clscode"];
  
  //同一クラスの商品をゲット
  $i=0;
  foreach($janmas as $key=>$val){
   if($i) $this->select.=",";
   $this->select.="t.".$key;
   $i++;
  }

  $this->from =TB_JANMAS." as t";
  $this->where =" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'";
  $this->where.=" and t.jcode<>".$jcode;
  $this->where.=" and t.clscode=".$clscode;
  $this->order=" t.lastsale desc";
  $this->items["data"]=$this->getArray();

  foreach($janmas as $key=>$val){
   $this->items["local"][]=$val["local"];
  }
  $this->items["status"]=true;
  return true;
 }//getLinItems





 //---------------------------------------------------------//
 // 同一ラインの商品マスタを返す(引数$jcodeは除く)
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getLinItems($jcode){
  //引数チェック
  if(! is_numeric($jcode)|| ! $jcode){
   throw new exception("JANコードが不正です");
  }

  //メンバーリセット
  $this->items=null;

  //テーブル情報ゲット
  $janmas=$GLOBALS["TABLES"][TB_JANMAS];

  //lincodeをゲット
  $this->select="t1.lincode";
  $this->from =TB_JANMAS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where=" t.jcode=".$jcode;
  if(! $this->items["data"]=$this->getArray()){
   $this->items["status"]=false;
   $this->items["data"]="JANコードがありません。";
   return false;
  }
  $lincode=$this->ary[0]["lincode"];
  
  //同一ラインの商品をゲット
  $i=0;
  foreach($janmas as $key=>$val){
   if($i) $this->select.=",";
   $this->select.="t.".$key;
   $i++;
  }

  $this->from =TB_JANMAS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where =" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'";
  $this->where.=" and t.jcode<>".$jcode;
  $this->where.=" and t1.lincode=".$lincode;
  $this->order=" t.lastsale desc";
  $this->items["data"]=$this->getArray();

  foreach($janmas as $key=>$val){
   $this->items["local"][]=$val["local"];
  }
  $this->items["status"]=true;
  return true;
 }//getLinItems

 //---------------------------------------------------------//
 // アイテムを表示するHTMLを作成
 // 返り値:<a>
 //---------------------------------------------------------//
 public function getHtmlJanMas($data){
  $html="";
  if($data["data"]) $html.="<h3>こんな商品も売れています</h3>\n";

  $i=0;
  foreach($data["data"] as $key=>$val){
   $html.="<a>";
   $html.="<div class='imgdiv'><img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'></div>\n";
   $html.="<div class='snamediv'>".$val["sname"]."</div>\n";
   $html.="<div class='baikadiv'>";
   if($val["price"]) $html.="<span>".$val["price"]."</span>";
   if(preg_match("/^[0-9]+$/",$val["price"]) && $val["price"]) $html.="円";
   $html.="</div>\n";
   $html.="<div class='kikandiv'>最終販売日:".date("n月j日",strtotime($val["lastsale"]))."</div>\n";
   $html.="</a>";
   $i++;
   if($i>=JANMASLIMIT) break; //config.php内参照
  }//foreach

  $html.="<div class='clr'></div>\n";
  return $html;
 }//getHtmlJanMas
}//JANMAS
?>
