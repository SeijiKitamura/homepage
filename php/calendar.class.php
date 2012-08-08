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
 public  $item;   //データを格納
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

 //---------------------------------------------------------//
 // カレンダーリストをゲット
 // 返り値:true false
 //       :$this->items[data]   本日以降のカレンダーデータ(年月）
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getCalendarList(){
  //アイテムリセット
  $this->items=null;

  //年月リストを作成
  $this->select =" date_format(hiduke,'%Y') as nen";
  $this->select.=",date_format(hiduke,'%c') as tuki";
  $this->select.=",count(hiduke) as cnt";
  $this->from   =TB_CAL;
  //$this->where  =" hiduke>'".date("Y-m-01")."'";
  $this->group  =" date_format(hiduke,'%Y')";
  $this->group .=",date_format(hiduke,'%c')";
  $this->order  =$this->group;
  $this->items["data"]=$this->getArray();
  $this->items["local"]=array("年","月","データ数");
  $this->items["status"]=true;
 }

 //---------------------------------------------------------//
 // カレンダーアイテムをゲット
 // 返り値:true false
 //       :$this->items[data]   選択月のカレンダーアイテム
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getCalendarItem($nen,$tuki){
  //引数チェック
  if(! CHKDATE($nen."-".$tuki."-01")) throw new exception("日付が不正です");

  //開始日,終了日セット
  $s=date("Y-m-d",mktime(0,0,0,$tuki  ,1,$nen));
  $e=date("Y-m-d",mktime(0,0,0,$tuki+1,0,$nen));
  
  //テーブル配列ゲット
  $table=$GLOBALS["TABLES"];

  //メンバーリセット
  $this->items=null;

  //データゲット
  $this->select="t.hiduke,t.title,t.rate";
  $this->select.=",count(t1.jcode) as cnt";
  $this->select.=",min(t2.lincode) as lincode";
  $this->select.=",min(t1.clscode) as clscode";
  $this->from =TB_CAL." as t";
  $this->from.=" inner join ".TB_JANMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode";
  $this->where=" t.hiduke between '".$s."' and '".$e."'";
  $this->where.=" and t1.lastsale>'".date("Y-m-d",strtotime("-60days"))."'";
  $this->group="t.hiduke,t.title,t.rate";
  $this->order=$this->group;
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"]=array( $table[TB_CAL]["hiduke"]["local"]
                              ,$table[TB_CAL]["title"] ["local"]
                              ,$table[TB_CAL]["rate"]  ["local"]
                              ,$table[TB_LINMAS]["lincode"]["local"]
                              ,$table[TB_CAL]["clscode"]["local"]
                              ,"データ数");
 }//getCalendarItem

 //---------------------------------------------------------//
 // 単日カレンダーアイテムをゲット
 // 返り値:true false
 //       :$this->items[data]   選択月のカレンダーアイテム
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getItem($hiduke){
  //引数チェック
  if(! CHKDATE($hiduke)) throw new exception("日付が不正です");

  //メンバーリセット
  $this->items=null;
  
  //月データをゲット
  $this->getCalendarItem(date("Y",strtotime($hiduke)),date("m",strtotime($hiduke)));

  //該当データゲット
  foreach($this->items["data"] as $key=>$val){
   if(strtotime($val["hiduke"])===strtotime($hiduke)){
    $this->item["data"]  =$this->items["data"][$key];
    $this->item["status"]=true;
    $this->item["local"] =$this->items["local"];
    break;
   }//if
  }//foreach
 }//getItem
 
 //---------------------------------------------------------//
 // ラインリストのHTMLを返す
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlCalList($data,$nen=null,$tuki=null){
  //ulのクラス名をセット
  $ulcls="";

  //リンク先URLをセット
  $url="calendar.php?";

  //リスト作成
  foreach($data["data"] as $key=>$val){
   //年表示
   if($n!=$val["nen"]){
    $li.="<li>".$val["nen"]."年</li>\n";
   }//if

   //月表示
   $seturl=$url."nen=".$val["nen"]."&tuki=".$val["tuki"];
   $li.="<li>";
   if($val["nen"]!=$nen && $val["tuki"]!=$tuki){
    $li.="<a href='".$seturl."'>";
   }
   $li.=$val["tuki"]."月(".$val["cnt"].")";
   if($val["nen"]!=$nen && $val["tuki"]!=$tuki) $li.="</a>";
   $li.="</li>\n";

   //年更新
   $n=$val["nen"];
  }//foreach

  $ul="<ul class='".$ulcls."'>\n".$li."</ul>\n";
  return $ul;
 }//getHtmlLinList

 //---------------------------------------------------------//
 // ラインリストのHTMLを返す
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlCalItem($data,$nen,$tuki){
  //引数チェック

  //開始日セット
  $s=mktime(0,0,0,$tuki,1,$nen);
  $y=date("w",$s);
  $s=$s-($y*60*60*24);

  //終了日セット
  $e=mktime(0,0,0,$tuki+1,0,$nen);
  $y=date("w",$e);
  $e=$e+(6-$y)*60*60*24;

  $html="";
  $youbi=array("日","月","火","水","木","金","土");

  //曜日をセット
  for($i=0;$i<count($youbi);$i++){
   $html.="<div class='youbi ";
   if($i==(count($youbi)-1)) $html.=" colend";
   $html.="'>".$youbi[$i]."</div>\n";
  }//for

  //開始日から終了日まで繰り返し
  $youbicnt=1;
  for($i=$s;$i<=$e;$i=$i+60*60*24){
   //枠と日付表示
   $html.="<div class='dayitem ";
   if($youbicnt%count($youbi)==0) $html.="colend ";
   if(($youbicnt/7)>4) $html.=" rowend ";

   $html.="'>";
   $html.="<h6>".date("j",$i)."</h6>";
   foreach($data["data"] as $key=>$val){
    if($i==strtotime($val["hiduke"])){
     //item.phpへのリンク生成
     $url ="item.php?lincode=".$val["lincode"]."&clscode=".$val["clscode"];
     $url.="&hiduke=".$val["hiduke"];

     $html.="<a href='".$url."'>";
     $html.="<div class='calimg'><img src=''></div>";
     $html.="<div class='caltitle'>".$val["title"]."(".$val["cnt"].")"."</div>";
     //英数字と日本語を分離
     preg_match("/[0-9A-z]+/",$val["rate"],$match);
     if($match){
      preg_match("/[^0-9A-z]+/",$val["rate"],$match2);
      $html.="<div class='calrate'>".$match[0]."<span>".$match2[0]."</span></div>";
     }
     else{
      $html.="<div class='calrate'>".$val["rate"]."</div>";
     }
     $html.="</a>";
    }//if
   }//foreach
   $html.="</div>";
   $youbicnt++;
  }//for

  return $html;
 } //getHtmlCalItem
}// CL

?>
