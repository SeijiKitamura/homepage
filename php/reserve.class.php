<?php
//-----------------------------------------------------------//
// reserve.class.php
// ご予約商品系クラス(db.class.phpをスーパークラス)
// このクラスを使用するときは必ずtry catchを使用すること
//-----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class RS extends DB{
 public  $items;   //データ
 private $columns; //テーブル列情報
 private $csvcol;  //CSV列情報

 function __construct(){
  parent::__construct();
  $this->columns=$GLOBALS["TABLES"][TB_RESERVE];
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_RESERVE];
  if(! $this->columns) throw new exception("テーブル情報がありません");
  if(! $this->csvcol)  throw new exception("CSV列情報がありません");
 }

//-----------------------------------------------------------//
// CSVファイル整合性をチェック
// 返り値:true false
//       :$this->items[data]   CSVデータを格納
//       :$this->items[local]  列名を格納
//       :$this->items[status] データ状態を格納
//-----------------------------------------------------------//
 public function checkData(){
  //データ初期化
  $this->items=null;

  //CSVファイルを配列に格納
  //（入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  $this->items=GETARRAYCSV(RESERVECSV,TB_RESERVE);
  return true;
 }//checkData


//-----------------------------------------------------------//
// CSVファイルをDBへ登録
// 返り値:true false
//       :$this->items[data]   CSVデータを格納
//       :$this->items[local]  列名を格納
//       :$this->items[status] データ状態を格納
//-----------------------------------------------------------//
 public function setData(){
  //データ初期化
  $this->items=null;

  //CSVファイルを配列へ格納
  $this->checkData();

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");

  //データ登録
  try{
   $this->BeginTran();
   //全データ削除
   $this->from=TB_RESERVE;
   $this->where="id>0";
   $this->delete();

   //SQL生成
   foreach($this->items["data"] as $rownum=>$row){
    //エラーチェック
    if($row["err"]!=="OK"){
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }

    //JANコード変換
    $jcode=GETJAN($row["jcode"]);
    if($jcode===FALSE){
     $this->items["data"][$rownum]["err"]="JANコードが不正です";
     $this->items["status"]=false;
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }
    $this->items["data"][$rownum]["jcode"]=$jcode;
    //SQL生成(err列を除く)
    foreach($this->csvcol as $colnum =>$colname){
     $this->updatecol[$colname]=$this->items["data"][$rownum][$colname];
    }
    $this->from=TB_RESERVE;
    $this->where="id=0";//無条件追加

    //SQL実行
    $this->update();
   }//foreach

   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
   throw $e;
  }//catch

 }//setData

 //-----------------------------------------------------------//
 // グループ1リストをゲット
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データ状態を格納
 //-----------------------------------------------------------//
 public function getGrp1(){
  $this->items=null;

  $this->columns=$GLOBALS["TABLES"][TB_RESERVE];

  $this->select="grp1,grp1name";
  $this->from =TB_RESERVE;
  $this->group=$this->select;
  $this->order=$this->select;
  $this->items["data"]=$this->getArray();
  if($this->items["data"]){
   $this->items["status"]=true;
  }//if
  else{
   $this->items["status"]=false;
  }//else
  $this->items["local"]["grp1"]=$this->columns["grp1"]["local"];
  $this->items["local"]["grp1name"]=$this->columns["grp1name"]["local"];
 }//getGrp1

 //-----------------------------------------------------------//
 // グループ2リストをゲット
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データ状態を格納
 //-----------------------------------------------------------//
 public function getGrp2($grp1=null){
  $this->items=null;
  $this->columns=$GLOBALS["TABLES"][TB_RESERVE];

  $this->select="grp2,grp2name";
  $this->from =TB_RESERVE;
  if($grp1) $this->where="grp1=".$grp1;
  $this->group=$this->select;
  $this->order=$this->select;
  $this->items["data"]=$this->getArray();
  if($this->items["data"]){
   $this->items["status"]=true;
  }//if
  else{
   $this->items["status"]=false;
  }//else
  $this->items["local"]["grp2"]=$this->columns["grp2"]["local"];
  $this->items["local"]["grp2name"]=$this->columns["grp2name"]["local"];
 }//getGrp2

 //-----------------------------------------------------------//
 // グループ3リストをゲット
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データ状態を格納
 //-----------------------------------------------------------//
 public function getGrp3($grp2=null){
  $this->items=null;
  $this->columns=$GLOBALS["TABLES"][TB_RESERVE];

  $this->select="grp3,grp3name";
  $this->from =TB_RESERVE;
  if($grp1) $this->where="grp2=".$grp2;
  $this->group=$this->select;
  $this->order=$this->select;
  $this->items["data"]=$this->getArray();
  if($this->items["data"]){
   $this->items["status"]=true;
  }//if
  else{
   $this->items["status"]=false;
  }//else
  $this->items["local"]["grp3"]=$this->columns["grp3"]["local"];
  $this->items["local"]["grp3name"]=$this->columns["grp3name"]["local"];
 }//getGrp3

 //-----------------------------------------------------------//
 // 商品リストをゲット
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データ状態を格納
 //-----------------------------------------------------------//
 public function getItemsList($grp1=null,$grp2=null,$grp3=null,$jcode=null){
  $this->items=null;
  $this->columns=$GLOBALS["TABLES"][TB_RESERVE];

  $this->select ="grp1,grp1name,grp2,grp2name,grp3,grp3name,clscode,jcode";
  $this->select.=",sname,maker,tani,baika,notice,view_start,view_end,flg";
  $col=explode(",",$this->select);
  $this->from=TB_RESERVE;
  $this->where ="flg=0"; 
  $this->where.=" and view_start <='".date("Y-m-d")."'";
  $this->where.=" and view_end >='".date("Y-m-d")."'";
  if($grp1) $this->where.=" and grp1=".$grp1;
  if($grp2) $this->where.=" and grp2=".$grp2;
  if($grp3) $this->where.=" and grp3=".$grp3;
  if($jcode)$this->where.=" and jcode=".$jcode;
  $this->items["data"]=$this->getArray();
  if($this->items["data"]) $this->items["status"]=true;
  else                     $this->items["status"]=false;

  foreach($col as $colnum=>$colname){
   $this->items["local"][$colname]=$this->columns[$colname]["local"];
  }//foreach
 }//getItemList
}//RS

?>
