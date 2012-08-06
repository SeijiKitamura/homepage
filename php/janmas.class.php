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
 // 商品マスタのクラスリストを返す
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getClsMas($lincode=null){

  //引数チェック
  if($lincode && ! is_numeric($lincode)) throw new exception("ラインコードは数字で入力してください");

  //データリセット
  $this->items=null;

  //テーブル情報ゲット
  $table=$GLOBALS["TABLES"][TB_CLSMAS];

  $this->select=" t1.clscode,t1.clsname,count(t.jcode) as cnt";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where=" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'";
  if($lincode) $this->where.=" and t1.lincode=".$lincode;
  $this->group=" t1.clscode,t1.clsname";
  $this->order=" t1.clscode";
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"]=array( $table["clscode"]["local"]
                              ,$table["clsname"]["local"]
                              ,"データ数");
 }//getLinMas



 //---------------------------------------------------------//
 // 商品マスタのラインリストを返す
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getLinMas(){
  $this->items=null;

  $table=$GLOBALS["TABLES"][TB_LINMAS];

  $this->select=" t2.lincode,t2.linname,count(t.jcode) as cnt";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where=" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'";
  $this->group=" t2.lincode,t2.linname";
  $this->order=" t2.lincode";
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"]=array( $table["lincode"]["local"]
                              ,$table["linname"]["local"]
                              ,"データ数");
 }//getLinMas

 //---------------------------------------------------------//
 // 商品リストを返す
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getJanMas($lincode=null,$clscode=null,$jcode=null,$datanum=null){
  //引数チェック
  if($lincode && ! is_numeric($lincode)) throw new exception("ラインコードは数字で入力してください");

  if($clscode && ! is_numeric($clscode)) throw new exception("クラスコードは数字で入力してください");

  if($jcode && ! is_numeric($jcode)) throw new exception("JANコードは数字で入力してください");

  if($datanum && ! is_numeric($datanum)) throw new exception("データ番号は数字で入力してください");

  //$table=$GLOBALS["TABLES"][TB_JANMAS];
  $table=$GLOBALS["TABLES"];

  //データリセット
  $this->items=null;

  //データゲット
  $this->select =" t.jcode,t.sname,t.stdprice,t.price,t.lastsale";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_JANMAS." as t ";
  $this->from.="inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'"; 
  if($lincode) $this->where.=" and t1.lincode=".$lincode;
  if($clscode) $this->where.=" and t.clscode=".$clscode;
  if($jcode)   $this->where.=" and t.jcode=".$jcode;
  $this->order ="t.lastsale desc,t2.lincode,t.clscode,t.jcode";
  //$this->items["data"]=$this->getArray();
  $d=$this->getArray();

  //データ開始位置をセット
  $start=$datanum;
  if($start===null) $start=0;

  //データ終了位置をセット
  $end=$start+JANMASLIMIT;
  if($end>count($d)) $end=count($d);

  //付番
  for($i=$start;$i<$end;$i++){
   $d[$i]["datanum"]=$i;
   $this->items["data"][]=$d[$i];
  }
  $this->items["total"]=count($d);
  $this->items["status"]=true;
  $this->items["local"]=array( $table[TB_JANMAS]["jcode"]["local"]
                              ,$table[TB_JANMAS]["sname"]["local"]
                              ,$table[TB_JANMAS]["stdprice"]["local"]
                              ,$table[TB_JANMAS]["price"]["local"]
                              ,$table[TB_JANMAS]["lastsale"]["local"]
                              ,$table[TB_CLSMAS]["clscode"]["local"]
                              ,$table[TB_CLSMAS]["clsname"]["local"]
                              ,$table[TB_LINMAS]["lincode"]["local"]
                              ,$table[TB_LINMAS]["linname"]["local"]
                             );
  //広告売価を反映
  $this->select ="t.jcode,t.tani,t.baika";
  $this->select.=",t1.clscode,t1.clsname";
  $this->from =TB_ITEMS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where ="t.hiduke='".date("Y-m-d")."'";
  if($lincode) $this->where.=" and t1.lincode=".$lincode;
  if($clscode) $this->where.=" and t1.clscode=".$clscode;
  if($jcode)   $this->where.=" and t.jcode=".$jcode;
  $this->order ="t1.lincode,t1.clscode,t.jcode";
  $tirasi=$this->getArray();
  
  foreach($this->items["data"] as $key=>$val){
   foreach($this->ary as $key1=>$val1){
    if($val["jcode"]===$val1["jcode"]){
     $val["maker"]=$val1["maker"];
     $val["tani"]=$val1["tani"];
     $val["price"]=$val1["baika"];
     $val["notice"]=$val1["notice"];
     $val["lastsale"]="広告の品";
     break;
    }//if
   }//foreach
  }//foreach

 }//getJanMas

 //---------------------------------------------------------//
 // アイテムを表示するHTMLを作成
 // 返り値:<a>
 //---------------------------------------------------------//
 public function getHtmlJanMas($data){
  //if($data["data"]) $html.="<h3>こんな商品も売れています</h3>\n";
  $html="";
  $i=0;
  foreach($data["data"] as $key=>$val){
   $url ="item.php?lincode=".$val["lincode"];
   $url.="&clscode=".$val["clscode"];
   $url.="&jcode=".$val["jcode"];
   $url.="&datanum=0";

   $html.="<a href='".$url."'>";
   $html.="<div class='imgdiv'><img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'></div>\n";
   $html.="<div class='snamediv'>".$val["sname"]."</div>\n";
   $html.="<div class='baikadiv'>";
   if($val["price"]) $html.="<span>".$val["price"]."</span>";
   if(preg_match("/^[0-9]+$/",$val["price"]) && $val["price"]) $html.="円";
   $html.="</div>\n";
   $html.="<div class='jcodediv'>JAN:".$val["jcode"]."</div>\n";
   $html.="<div class='kikandiv'>最終販売日:".date("n月j日",strtotime($val["lastsale"]))."</div>\n";
   $html.="</a>";
   $i++;
   if($i>=JANMASLIMIT) break; //config.php内参照
  }//foreach

  $html.="<div class='clr'></div>\n";
  return $html;
 }//getHtmlJanMas
 
 //---------------------------------------------------------//
 // ラインリストのHTMLを返す
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlLinList($data,$lincode){
  //ulのクラス名をセット
  $ulcls="";

  //リンク先URLをセット
  $url="item.php?datanum=0&lincode=";

  //リスト作成
  foreach($data["data"] as $key=>$val){
   $li.="<li>";
   if($val["lincode"]!=$lincode) $li.="<a href='".$url.$val["lincode"]."'>";
   $li.=$val["linname"]."(".$val["cnt"].")";
   if($val["lincode"]!=$lincode) $li.="</a>";
   $li.="</li>\n";
  }//foreach

  $ul="<ul class='".$ulcls."'>\n".$li."</ul>\n";
  return $ul;
 }//getHtmlLinList

 //---------------------------------------------------------//
 // クラスリストのHTMLを返す
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlClsList($data,$lincode,$clscode){
  //ulのクラス名をセット
  $ulcls="";

  //リンク先URLをセット
  $url="item.php?datanum=0&lincode=".$lincode."&clscode=";

  //リスト作成
  foreach($data["data"] as $key=>$val){
   $li.="<li>";
   if($val["clscode"]!=$clscode) $li.="<a href='".$url.$val["clscode"]."'>";
   $li.=$val["clsname"]."(".$val["cnt"].")";
   if($val["clscode"]!=$clscode) $li.="</a>";
   $li.="</li>\n";
  }//foreach

  $ul="<ul class='".$ulcls."'>\n".$li."</ul>\n";
  return $ul;
 }//getHtmlLinList
}//JANMAS
?>
