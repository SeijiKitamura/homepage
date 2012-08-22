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
//  getDayList()        販売日、商品数を返す
//  getItemList()       指定した日の商品リストを返す
//  getImageList()      指定した掲載号の商品リストを返す
//  getLinList()        指定した日のラインリストを返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class TIRASI extends DB{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報

 function __construct(){
  parent::__construct();

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
  //$this->items=CHKDATA(TITLECSV,TB_TITLES);//function.php内参照
  $this->items=GETARRAYCSV(TITLECSV,TB_TITLES);//function.php内参照
  
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
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkDataTitle();

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");
  //if(! $this->items["status"]) return false;
   
  try{
   $this->BeginTran();
   //CSV最初のチラシ番号以降のデータを削除
   $this->from=TB_TITLES;
   $this->where="tirasi_id>=".$this->items["data"][0]["tirasi_id"];
   $this->delete();

   //CSV登録
   foreach ($this->items["data"] as $rownum =>$row){
    //エラーチェック
    if($row["err"]!=="OK"){
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }//if

    //SQL生成(err列を除く)
    foreach($this->csvcol as $colnum=>$colname){
     $this->updatecol[$colname]=$this->items["data"][$rownum][$colname];
    }
    $this->from=TB_TITLES;
    $this->where="tirasi_id=".$row["tirasi_id"];
    $this->update();
   }//foreach
   $this->Commit();

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

  //CSVファイルをゲット
  //$this->items["data"]=CHKDATA(ITEMCSV,TB_ITEMS);//function.php内参照
  $this->items=GETARRAYCSV(ITEMCSV,TB_ITEMS);//function.php内参照
  
  return true;
 }// checkDataITEM

 //---------------------------------------------------------//
 // チラシアイテムのCSVファイルをDBへ登録
 // (商品はチラシ番号順に並んでいることを前提にしています）
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataItem(){
  //CSVファイルを配列へ格納
  $this->checkDataItem();

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");
  
  //データ登録
  try{
   $this->BeginTran();
   foreach($this->items["data"] as $rownum=>$row){
    //既存チラシを一括削除
    if($tirasi_id!==$row["tirasi_id"]){
     $this->from=TB_ITEMS;
     $this->where="tirasi_id=".$row["tirasi_id"];
     $this->delete();
    }//if

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
    foreach($this->csvcol as $colnum=>$colname){
     $this->updatecol[$colname]=$this->items["data"][$rownum][$colname];
    }
    $this->from=TB_ITEMS;
    $this->where ="     tirasi_id=".$row["tirasi_id"];
    $this->where.=" and hiduke   ='".$row["hiduke"]."'";
    $this->where.=" and jcode    =".$row["jcode"];
    $this->update();

    //チラシ番号更新
    $tirasi_id=$row["tirasi_id"];
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
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
 function getTitleList($hiduke=null){
  //引数チェック
  if($hiduke && ! CHKDATE($hiduke)){
   throw new exception("日付を確認してください。");
  }

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
  if($hiduke){
   $this->where="view_end>='".$hiduke."'";
  }
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
 // 指定した単一掲載号の日別商品リストを返す
 // 返り値:true
 //       :$this->items[data]   サイズ変更後の画像パス
 //       :$this->items[local]  列名
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 public function getItemList($tirasi_id=null,$hiduke =null,$lincode=null,$jcode=null){
  //引数チラシ番号チェック(nullなら直近データ表示)
  if(! $tirasi_id){
   $this->getTitleList(date("Y-m-d"));
   if($this->items){
    $tirasi_id=$this->items["data"][0]["tirasi_id"];
    $hiduke=$this->items["data"][0]["hiduke"];
   }//if
  }//if
  
  if($tirasi_id && ! is_numeric($tirasi_id)){
   $this->items["data"]="チラシ番号は数字で入力してください";
   $this->items["status"]=false;
   return false;
  }//if

  if($tirasi_id && ! $hiduke){
   //チラシ投函日をセット
   $this->select="hiduke";
   $this->from =TB_TITLES;
   $this->where="tirasi_id=".$tirasi_id;
   $this->getArray();
   $hiduke=$this->ary[0]["hiduke"];
  }//if

  if($tirasi_id && $hiduke!=="all" && !CHKDATE($hiduke)){
   throw new exception("日付が無効です");
  }
  
  if($lincode && ! is_numeric($lincode)){
   throw new exception("部門番号が無効です");
  }

  if($jcode && ! is_numeric($jcode)){
   throw new exception("JANコードが無効です");
  }

  //メンバーリセット
  $this->items=null;

  //表示する列名をセット
  $col =" t.saletype";
  $col.=",t.subtitle";
  $col.=",t.jcode";
  $col.=",t.sname";
  $col.=",t.maker";
  $col.=",t.tani";
  $col.=",t.baika";
  $col.=",t.notice";
  $col.=",t.specialflg";
  $col.=",t1.clscode";
  $col.=",t3.lincode";
  $col.=",t.tirasi_id";

  $grpcol =",min(t.hiduke) as startday";
  $grpcol.=",max(t.hiduke) as endday";
  $this->select=$col.$grpcol;
  $this->from =TB_ITEMS." as t inner join ".TB_JANMAS." as t1 on ";
  $this->from.=" t.jcode=t1.jcode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t3 on";
  $this->from.=" t2.lincode=t3.lincode";

  $this->where ="t.tirasi_id=".$tirasi_id;
  if($hiduke!=="all"){
   $this->where.=" and t.hiduke>='".$hiduke."'";
  }//if

  if($lincode){
   $this->where.=" and t3.lincode=".$lincode;
  }//if

  if($jcode){
   $this->where.=" and t.jcode=".$jcode;
  }//if

  $this->group =$col;
  if($hiduke!=="all"){
   $this->group.=" having min(t.hiduke)='".$hiduke."'";
  }//if

  //並び順をセット
  $this->order =" t.tirasi_id";   //チラシ番号
  $this->order.=",min(t.hiduke)"; //掲載開始日
  $this->order.=",max(t.hiduke)"; //掲載終了日
  $this->order.=",t.saletype";    //通常、イベント
  $this->order.=",t.subtitle";    //タイトル
  $this->order.=",t.specialflg desc";  //目玉、通常
  $this->order.=",t1.clscode";    //TB_JANMASのクラスコード
  $this->order.=",t.jcode";

  $this->items["data"]  =$this->getArray();
  $this->items["status"]=true;
  $this->items["local"] =array( "セールタイプ"
                               ,"イベント名"
                               ,"JANコード"
                               ,"商品名"
                               ,"メーカー"
                               ,"販売単位"
                               ,"売価"
                               ,"コメント"
                               ,"目玉"
                               ,"クラスコード"
                               ,"部門番号"
                               ,"チラシ番号"
                               ,"販売開始日"
                               ,"販売終了日"
                              );
   //本当はconfig.php内の$TABLES[テーブル名]["local"]をセットしたい
 }//getItemList()

 //---------------------------------------------------------//
 // 販売日、商品数を返す
 // 返り値:true
 //       :$this->items[data]   販売日、商品数
 //       :$this->items[local]  列名
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 function getDayList($tirasi_id,$lincode=null){
  //引数チラシ番号チェック(nullなら直近データ表示)
  if(! $tirasi_id){
   $this->getTitleList(date("Y-m-d"));
   if($this->items){
    $tirasi_id=$this->items["data"][0]["tirasi_id"];
   }//if
  }//if
  
  if(! is_numeric($tirasi_id)){
   throw new exception("チラシ番号は数字で指定してください");
  }//if

  //メンバ変数リセット
  $this->items=null;

  //データ表示
  $this->select="t.hiduke,count(t.jcode) as items";
  $this->from =TB_ITEMS." as t";
  $this->from.=" inner join ".TB_JANMAS." as t1 on";
  $this->from.=" t.jcode=t1.jcode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode";
  $this->where="tirasi_id=".$tirasi_id;
  if($lincode) $this->where.=" and t2.lincode=".$lincode;
  $this->group="hiduke";
  $this->order="hiduke";

  $this->items["data"]=$this->getArray();
  $this->items["local"]=array("日付","商品数");
  $this->items["status"]=true;
 }//getDayList()
 //---------------------------------------------------------//

 //---------------------------------------------------------//
 // 指定した単一掲載号の商品リストを返す
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

 //---------------------------------------------------------//
 // 指定した日のラインリストを返す
 // 返り値:true
 //       :$this->items[data]   サイズ変更後の画像パス
 //       :$this->items[local]  列名
 //       :$this->items[status] 処理の状態を格納(true false)
 //---------------------------------------------------------//
 public function getLinList($tirasi_id,$hiduke){
  //引数チェック
  if(! $tirasi_id || ! is_numeric($tirasi_id)){
   throw new exception("チラシ番号が不正です");
  }

  if(! $hiduke || ! CHKDATE($hiduke)){
   throw new exception("日付が不正です");
  }


  //メンバリセット
  $this->items=null;
  $this->columns=null;

  $this->select =" t.hiduke";
  $this->select.=",t3.lincode";
  $this->select.=",t3.linname";
  $this->select.=",count(t.hiduke) as cnt";
  $this->from =TB_ITEMS." as t ";
  $this->from.=" inner join ".TB_JANMAS." as t1 on";
  $this->from.=" t.jcode=t1.jcode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t3 on";
  $this->from.=" t2.lincode =t3.lincode";
  $this->where =" t.tirasi_id=".$tirasi_id;
  $this->where.=" and t.hiduke='".$hiduke."'";
  $this->group ="t.hiduke,t3.lincode,t3.linname";
  $this->order =$this->group;

  //データセット
  $this->items["data"]=$this->getArray();
  $this->items["status"]=true;
  $this->items["local"][]=$GLOBALS["TABLES"][TB_ITEMS]["hiduke"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["lincode"]["local"];
  $this->items["local"][]=$GLOBALS["TABLES"][TB_LINMAS]["linname"]["local"];
  $this->items["local"][]="データ数";
 }//getLinList()

 //---------------------------------------------------------//
 // チラシを表示するのに必要なデータを一括で用意
 // 返り値:配列
 //---------------------------------------------------------//
 public function getData($tirasi_id=null,$hiduke=null,$lincode=null,$jcode=null){
  $data=null;

  //タイトル一覧
  $this->getTitleList(date("Y-m-d"));
  $data["titles"]=$this->items;

  //販売日一覧
  $this->getDayList($tirasi_id,$lincode);
  $data["days"]=$this->items;

  //指定日の商品一覧
  $this->getItemList($tirasi_id,$hiduke,$lincode);
  $data["items"]=$this->items;

  //チラシ全体の商品一覧
  $this->getItemList($tirasi_id,"all");
  $data["allitems"]=$this->items;

  //タイトル確定
  foreach($data["titles"]["data"] as $key=>$val){
   if($val["tirasi_id"]==$data["items"]["data"][0]["tirasi_id"]){
    $data["title"]["data"]=$val;
    $data["title"]["status"]=true;
    $data["title"]["local"]=$data["titles"]["local"];
    break;
   }//if
  }//foreach
  
  //ラインリスト
  $this->getLinList($tirasi_id,$hiduke);
  $data["linlist"]=$this->items;

  //翌日の同一linのチラシ商品(表示している単品を除く) 
  $nextday=date("Y-m-d",strtotime("+1 day",strtotime($hiduke)));
  $this->getItemList($tirasi_id,$nextday,$lincode);
  $d=$this->items["data"];
 
  foreach($d as $key=>$val){
   $flg=1;
   foreach($data["items"]["data"] as $key1=>$val1){
    if($val["jcode"]==$val1["jcode"] || $val["jcode"]==$jcode){
     $flg=0;
     break;
    }//if
   }//foreach
   if($flg) $data["nextitems"]["data"][]=$val;
  }//foreach
  if($data["nextitems"]){
   $data["nextitems"]["status"]=true;
   $data["nextitems"]["local"]=$data["items"]["local"];
  }

  //単品確定    
  if($jcode){
   $this->getItemList($tirasi_id,$hiduke,$lincode,$jcode);
   $data["item"]=$this->items;
   
   //同日の同一linのチラシ商品(表示している単品を除く) 
   foreach($data["items"]["data"] as $key=>$val){
    $flg=1;
    if($val["jcode"]==$jcode){
     $flg=0;
    }//if
    if($flg) $data["linitems"]["data"][]=$val;
   }//foreach
   if($data["linitems"]){
    $data["linitems"]["status"]=true;
    $data["linitems"]["local"]=$data["items"]["local"];
   }
 
  }//if($jan)

  return $data;
 }//getData()

 //---------------------------------------------------------//
 // 販売日リストのHTMLを返すクラス
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlDaysList($data,$tirasi_id,$hiduke,$lincode=null){
  //リンク先URLをセット
  $url="tirasi.php?tirasi_id=".$tirasi_id."&lincode=".$lincode;

  //リスト作成開始
  $li="";
  foreach($data["data"] as $key=>$val){
   $li.="<li>";
   if($hiduke!=$val["hiduke"]){
    $li.="<a href='".$url."&hiduke=".$val["hiduke"]."'>";
   }//if
   $li.=date("n月j日 ",strtotime($val["hiduke"]));
   $li.="(".$val["items"].")";
   if($hiduke!=$val["hiduke"]) $li.="</a>";
   $li.="</li>\n";
  }//foreach
  $ul="<ul class='dayslist'>\n".$li."</ul>\n";
  $ul.="<div class='clr'></div>\n";
  return $ul;
 }//getHtmlDaysList()

 //---------------------------------------------------------//
 // ラインリストのHTMLを返すクラス
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlLinList($data,$tirasi_id,$hiduke,$lincode=null){
  //ulのクラス名をセット
  $ulcls="";

  //リンク先URLをセット
  $url ="./tirasi.php?tirasi_id=".$tirasi_id."&hiduke=".$hiduke."&lincode=";

  $li="";
  $li ="<li>";
  if($lincode) $li.="<a href='".$url."'>";
  $li.="すべての商品";
  if($lincode) $li.="</a>";
  $li.="<li>\n";

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
 // 商品のHTMLを返すクラス
 // 返り値:<a>
 //---------------------------------------------------------//
 public function getHtmlItem($data,$path){
  //リセット
  $endday=null;
  $html="";

  foreach($data["data"] as $key=>$val){
    //終了日が変われば期間を表示
    if($val["endday"]!==$endday){
     if($val["startday"]===$val["endday"]){
      $msg=date("n月j日",strtotime($val["endday"]))."限り";
     }
     else{
     $msg =date("n月j日",strtotime($val["startday"]))."から";
     $msg.=date("n月j日",strtotime($val["endday"]))."まで";
     }
     $html.="<div class='clr'></div>\n";
     $html.="<h3>".$msg."</h3>\n";
    }//if

    //subtitleが変更すればタイトル表示
    if($val["subtitle"] && $val["subtitle"]!==$subtitle){
     $html.="<div class='clr'></div>\n";
     $html.="<h4>".$val["subtitle"]."</h4>\n";
    }//if

    //商品表示(目玉なら特別表示)
    $url =$path."?tirasi_id=".$val["tirasi_id"];
    $url.="&hiduke=".$val["startday"];
    $url.="&lincode=".$val["lincode"];
    $url.="&jcode=".$val["jcode"];
    $html.="<a href='".$url."'>\n"; //単品画面へリンク
    $html.="<div class='imgdiv'><img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'></div>\n";
    $html.="<div class='makerdiv'>".$val["maker"]."</div>\n";
    $html.="<div class='snamediv'>".$val["sname"]."</div>\n";
    $html.="<div class='tanidiv'>".$val["tani"]."</div>\n";
    $html.="<div class='baikadiv'><span>".$val["baika"]."</span>円</div>\n";
    $html.="<div class='noticediv'>".$val["notice"]."</div>\n";
    $html.="<div class='jcodediv'>JAN:".$val["jcode"]."</div>\n";
    $html.="<div class='kikandiv'>".$msg."</div>\n";
    $html.="</a>\n";

    //現在の値をセット
    $endday=$val["endday"];
    $subtitle=$val["subtitle"];
  }//foreach

  $html.="<div class='clr'></div>\n";
  return $html;
 }//getHtmlItem
}//TIRASI

?>
