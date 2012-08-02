<?php
//----------------------------------------------------------//
//  tirasi.class.php 
//  広告系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
// データ更新系
//----------------------------------------------------------//
//  checkDataTitle()    チラシタイトルのCSVファイルのデータ整合性をチェック
//  setDataTitle()      チラシタイトルのCSVファイルをDBへ登録
//  checkDataItem()     チラシアイテムのCSVファイルのデータ整合性をチェック
//  setDataItem()       チラシアイテムのCSVファイルをDBへ登録
//  CovertImage()       指定されたURLが画像をゲットしコンバート
//----------------------------------------------------------//
// データ表示系
//----------------------------------------------------------//
//  getTitleList()      チラシタイトル一覧
//  getImageList()      指定した単一掲載号のチラシ商品リストを返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class TIRASI extends DB{
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
 public function checkDataTitle(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  //(入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  $this->items=CHKDATA(TITLECSV,TB_TITLES);//function.php内参照
  
  return true;
 }// checkDataTitle
 
 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataTitle(){
  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_TITLES];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_TITLES];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkDataTitle();
  if(! $this->items["status"]) return false;
   
  //エラーフラグ
  $flg=0;

  //CSVのチラシ番号列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="tirasi_id"){
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="チラシ番号列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if

  //CSVの最初のチラシ番号をゲット
  $tirasi_id=$this->items["data"][0][$i];

  try{
   //トランザクション開始
   $this->BeginTran();

   //既存データ削除
   $this->from=TB_TITLES;
   $this->where="tirasi_id>='".$tirasi_id."'";
   $this->delete();
   

   //CSVデータ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_TITLES;
    $this->where="tirasi_id=0";//無条件追加
    $this->update();
   }//for

   //コミット
   $this->Commit();

   return true;

  }//try
  catch(Exception $e){
   $this->items["status"]=false;
   $this->RollBack();
   throw $e;
  }//catch
 }// setDataTitle

 //---------------------------------------------------------//
 // CSVファイルの整合性をチェック
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function checkDataItem(){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->items["data"]=CHKDATA(ITEMCSV,TB_ITEMS);//function.php内参照
  
  return true;
 }// checkDataITEM

 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataItem(){
 //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_ITEMS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_ITEMS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->items=CHKDATA(ITEMCSV,TB_ITEMS);//function.php内参照
  if(! $this->items["status"]) return false;

  //エラーフラグ
  $flg=0;

  //CSVのチラシ番号列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="tirasi_id"){
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="チラシ番号列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if

  //CSVのチラシ番号リストを作成
  $colnum=$i;
  for($i=0;$i<count($this->items["data"]);$i++){
   if($t!=$this->items["data"][$i][$colnum]){
    $tirasi_id[]=$this->items["data"][$i][$colnum];
    $t=$this->items["data"][$i][$colnum];
   }//if
  }//for

  try{
   //トランザクション開始
   $this->BeginTran();

   //既存データ削除
   for($i=0;$i<count($tirasi_id);$i++){
    $this->from=TB_ITEMS;
    $this->where="tirasi_id=".$tirasi_id[$i];
    $this->delete();
   }
   

   //CSVデータ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_ITEMS;
    $this->where="tirasi_id=0";//無条件追加
    $this->update();
   }//for

   //コミット
   $this->Commit();

   return true;

  }//try
  catch(Exception $e){
   $this->items["status"]=false;
   $this->RollBack();
   throw $e;
  }//catch
 }//setDataItem
 
 //---------------------------------------------------------//
 // チラシタイトル一覧を返す
 // 返り値:true
 //       :$this->items[data]   サイズ変更後の画像パス
 //       :$this->items[local]  列名
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 function getTitleList(){
  //引数チェック
  //表示する列名をセット
  $col=array( "hiduke"
             ,"title"
             ,"view_start"
             ,"view_end"
             ,"tirasi_id"
            );

  //列情報を$this->columnsへ格納
  foreach($col as $key=>$val){
   foreach($GLOBALS["TABLES"][TB_TITLES] as $key1=>$val1){
    if($val==$key1){
     $this->columns[$val]=$val1;
     break;
    }//if
   }//foreach
  }//foreach
  
  //データ表示用SQL生成
  $i=0;
  foreach($this->columns as $key=>$val){
   if($i) $this->select.=",";
   $this->select.=$key;
   $i++;
  }//foreach
  $this->from=TB_TITLES;
  $this->order=$this->select;
  $this->items["data"]=$this->getArray();

  //表示する列名をセット
  foreach($this->columns as $key=>$val){
   $this->items["local"][]=$val["local"];
  }

  //status更新
  $this->items["status"]=true;
  
  return true;
 
 }//getTitleList()

 //---------------------------------------------------------//
 // 指定した単一掲載号のチラシ商品リストを返す
 // 返り値:true
 //       :$this->items[data]   サイズ変更後の画像パス
 //       :$this->items[local]  列名
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 public function getImageList($tirasi_id){
  //引数チェック
  if(! $tirasi_id || ! is_numeric($tirasi_id)){
   throw new exception("チラシ番号が不正です");
  }

  //表示する列名をセット
  $col=array(  "lincode"
              ,"jcode"
              ,"maker"
              ,"sname"
              ,"tani"
              ,"baika"
    );

  //列情報を$this->columnsへ格納
  foreach($col as $key=>$val){
   foreach($GLOBALS["TABLES"][TB_ITEMS] as $key1=>$val1){
    if($val==$key1){
     $this->columns[$val]=$val1;
     break;
    }//if
   }//foreach
  }//foreach

  //表示するデータのSQL生成
  $i=0;
  foreach($this->columns as $key=>$val){
   if($i) $this->select.=",";
   $this->select.=$key;
   $i++;
  }//foreach
  $this->from=TB_ITEMS;
  $this->where="tirasi_id=".$tirasi_id;
  $this->group=$this->select;
  $this->order=$this->select;
  $this->items["data"]=$this->getArray();

  //表示する列名をセット
  foreach($this->columns as $key=>$val){
   $this->items["local"][]=$val["local"];
  }

  //status更新
  $this->items["status"]=true;
  
  return true;
 }//getImageList

 //---------------------------------------------------------//
 // 外部画像ファイルをサイズ変更してimgディレクトリへ保存
 // 返り値:true false
 //       :$this->items[data]   サイズ変更後の画像パス
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 public function ConvertImage($jcode,$url){
  if(! is_numeric($jcode)) throw new exception("JANコードが数字ではありません");

  if(! $url) throw new exception("画像取得先アドレスを入力してください");

  //画像取得
  if(! $img=file_get_contents($url)){
   throw new exception("画像を取得できませんでした");
  }

  //画像保存
  if(! file_put_contents(DATADIR.$jcode,$img)){
   throw new exception("画像を保存できませんでした");
  }

  if(! chmod(DATADIR.$jcode,0660)) throw new exception("ファイル属性変更に失敗しました");
  
  //shellでコンバート
  $cmd=escapeshellcmd("convert -geometry 120 ".DATADIR.$jcode." ".IMGDIR.$jcode.".jpg");
  exec($cmd,$err);

  if($err) throw new exception("画像変換に失敗しました");

  //パーミッション変更
  if(! file_exists(IMGDIR.$jcode.".jpg")) throw new exception("ファイル変換に失敗しました");

  if(! chmod(IMGDIR.$jcode.".jpg",0660)) throw new exception("ファイル属性変更に失敗しました");
  
  $this->items=null;
  $this->items["data"]=$jcode.".jpg";
  $this->items["status"]=true;

  return true;
 }//ConvertImage()
}//TIRASI

?>
