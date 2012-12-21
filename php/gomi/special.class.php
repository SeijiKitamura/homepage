<?php
//-----------------------------------------------------------//
// special.class.php
// ご予約商品系クラス(db.class.phpをスーパークラス)
// このクラスを使用するときは必ずtry catchを使用すること
//-----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class SP extends DB{
 public  $items;   //データ
 private $columns; //テーブル列情報
 private $csvcol;  //CSV列情報

 function __construct(){
  parent::__construct();
  $this->columns=$GLOBALS["TABLES"][TB_SPECIAL];
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_SPECIAL];
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
  $this->items=GETARRAYCSV(SPECIALCSV,TB_SPECIAL);
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
   $this->from=TB_SPECIAL;
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
    $this->from=TB_SPECIAL;
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


}//SP

?>
