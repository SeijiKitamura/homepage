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


  //CSVファイルをゲット
  //(入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  //$this->items=CHKDATA(JANCSV,TB_JANMAS);//function.php内参照
  $this->items=GETARRAYCSV(JANCSV,TB_JANMAS);//function.php内参照
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

  //CSVファイルをゲット
  $this->checkData();             

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");

  //データ登録
  try{
   $this->BeginTran();
   //SQL生成
   foreach($this->items["data"] as $rownum =>$row){
    //エラーチェック
    if($row["err"]!=="OK"){
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }//if

    //JANコード変換
    $jcode=GETJAN($row["jcode"]);
    if($jcode===FALSE){
     $this->items["status"]=false;
     $this->items["data"][$rownum]["err"]="JANコードが不正です";
     $row["err"]="JANコードが不正です";
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }//if
    $this->items["data"][$rownum]["jcode"]=$jcode;

    //SQL生成(err列を除く)
    foreach($this->csvcol as $colnum =>$colname){
     $this->updatecol[$colname]=$this->items["data"][$rownum][$colname];
    }//foreach
    $this->from=TB_JANMAS;
    $this->where="jcode='".$jcode."'";
    
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
 // ($jcodeが指定されている場合、flgを有効にするとその商品を除く)
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getJanMas($lincode=null,$clscode=null,$jcode=null,$datanum=null,$word=null,$flg=null){
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
  if($jcode && ! $flg)   $this->where.=" and t.jcode=".$jcode;
  else $this->where.=" and t.jcode<>".$jcode;
  //検索ワード指定
  if($word){
   //検索条件をリセット
   $this->where=null;

   //検索ワード生成
   $w =SEARCHWORD($word);
   $this->items["search"]=$w;
   //検索条件生成($where)
   $wh =" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'"; 
   for($i=0;$i<count($w);$i++){
    if($w[$i] && strlen($w[$i])>3){ //3文字以上
     if($where) $where.=" or ";
     $where.=$wh." and t.jcode like '%".$w[$i]."%'";
     $where.=" or ".$wh." and t.sname like '%".$w[$i]."%'";
    }//if
   }//for
   $this->where=$where;
  }//if
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
  $this->select.=",t1.clscode,t2.clsname";
  $this->from =TB_ITEMS." as t ";
  $this->from.=" inner join ".TB_JANMAS." as t1 on";
  $this->from.=" t.jcode=t1.jcode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode";
  $this->where ="t.hiduke='".date("Y-m-d")."'";
  //if($lincode) $this->where.=" and t2.lincode=".$lincode;
  //if($clscode) $this->where.=" and t1.clscode=".$clscode;
  //if($jcode)   $this->where.=" and t.jcode=".$jcode;
  $this->order ="t2.lincode,t1.clscode,t.jcode";
  $tirasi=$this->getArray();
  foreach($this->items["data"] as $key=>$val){
   //foreach($this->ary as $key1=>$val1){
   foreach($tirasi as $key1=>$val1){
    if($val["jcode"]===$val1["jcode"]){
     $val["maker"]=$val1["maker"];
     $val["tani"]=$val1["tani"];
     $val["price"]=$val1["baika"];
     $val["notice"]=$val1["notice"];
     $this->items["data"][$key]=$val;
     break;
    }//if
   }//foreach
  }//foreach
 }//getJanMas

 //---------------------------------------------------------//
 // 新規登録商品リストを返す
 // 返り値:true false
 //       :$this->items[data]   商品マスタを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function getNewItem(){
  //データリセット
  $this->items=null;
  
  //抽出基準をセット
  $d=date("Y-m-d",strtotime("-".SALESTART."days"));

  $table=$GLOBALS["TABLES"];
  //データゲット
  $this->select ="t2.lincode,t.clscode,t.jcode,t.sname";
  $this->select.=",t.stdprice,t.price,t.salestart,t.lastsale";
  $this->from =TB_JANMAS ." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where ="t.salestart>'".$d."'";
  $this->where.="and t.lastsale>'".$d."'";
  $this->order ="t.salestart desc,t.clscode desc,t.jcode";
  $janmas=$this->getArray();

  //広告売価を反映
  $this->select ="t.jcode,t.tani,t.baika";
  $this->from =TB_ITEMS." as t ";
  $this->where ="t.hiduke='".date("Y-m-d")."'";
  $this->order ="t.jcode";
  $tirasi=$this->getArray();
  foreach($janmas as $key=>$val){
   foreach($tirasi as $key1=>$val1){
    if($val["jcode"]==$val1["jcode"]){
     $val["price"]=$val1["baika"];
     break;
    }//if
   }//foreach
  }//foreach

  $this->items["data"]=$janmas;
  $this->items["status"]=true;
  $this->items["local"]=array( $table[TB_JANMAS]["clscode"]["local"]
                              ,$table[TB_JANMAS]["jcode"]["local"]
                              ,$table[TB_JANMAS]["sname"]["local"]
                              ,$table[TB_JANMAS]["stdprice"]["local"]
                              ,$table[TB_JANMAS]["price"]["local"]
                              ,$table[TB_JANMAS]["salestart"]["local"]
                              ,$table[TB_JANMAS]["lastsale"]["local"]
                             );

 }//public function getNewItem(){

/*
 public function getSearchItem($word){
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
  $this->where.=" and t.jcode like '%".$word."%'";
  $this->where.=" or ";
  $this->where.=" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'"; 
  $this->where.=" and t.sname like '%".$word."%'";
  //$this->where.=" or ";
  //$this->where.=" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'"; 
  //$this->where.=" and t.price like '%".$word."%'";
  //$this->where.=" or ";
  //$this->where.=" t.lastsale>='".date("Y-m-d",strtotime("-60days"))."'"; 
  //$this->where.=" and t.lastsale like '%".$word."%'";
  $this->order ="t.lastsale desc,t2.lincode,t.clscode,t.jcode";
  //$this->items["data"]=$this->getArray();
  $this->items["data"]=$this->getArray();


 }//getSearchItem
*/
 //---------------------------------------------------------//
 // アイテムを表示するHTMLを作成
 // 返り値:<a>
 //---------------------------------------------------------//
 public function getHtmlJanMas($data,$datanum=null,$hiduke=null,$jcode=null){
  //if($data["data"]) $html.="<h3>こんな商品も売れています</h3>\n";
  $html="";
  $i=0;
  foreach($data["data"] as $key=>$val){
   //url生成
   $url ="item.php?lincode=".$val["lincode"];
   $url.="&clscode=".$val["clscode"];
   $url.="&jcode=".$val["jcode"];
   $url.="&datanum=".$datanum;
   $url.="&hiduke=".$hiduke;
   //$url.="&datanum=0";
   if($jcode) $html="<a>";
   else  $html.="<a href='".$url."'>";

   //img生成
   $html.="<div class='imgdiv'>";
   if(file_exists("./img/".$val["jcode"].".jpg")){
    $html.="<img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'>";
   }
   $html.="</div>\n";

   //商品情報生成
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
 public function getHtmlLinList($data,$lincode,$hiduke=null){
  //ulのクラス名をセット
  $ulcls="grouplist";

  //リンク先URLをセット
  $url="item.php?hiduke=".$hiduke."&datanum=0&lincode=";

  //リスト作成
  foreach($data["data"] as $key=>$val){
   $li.="<li>";
   if($val["lincode"]!=$lincode) $li.="<a href='".$url.$val["lincode"]."'>";
   $li.=$val["linname"]."(".$val["cnt"].")";
   if($val["lincode"]!=$lincode) $li.="</a>";
   $li.="</li>\n";
  }//foreach

  $ul="<ul class='".$ulcls."'>\n".$li."</ul>\n";
  //$ul.="<div class='clr'></div>";
  return $ul;
 }//getHtmlLinList

 //---------------------------------------------------------//
 // クラスリストのHTMLを返す
 // 返り値:<ul>
 //---------------------------------------------------------//
 public function getHtmlClsList($data,$lincode,$clscode,$hiduke=null){
  //ulのクラス名をセット
  $ulcls="grouplist";

  //リンク先URLをセット
  $url="item.php?hiduke=".$hiduke."&datanum=0&lincode=".$lincode."&clscode=";

  //リスト作成
  foreach($data["data"] as $key=>$val){
   $li.="<li>";
   if($val["clscode"]!=$clscode) $li.="<a href='".$url.$val["clscode"]."'>";
   $li.=$val["clsname"]."(".$val["cnt"].")";
   if($val["clscode"]!=$clscode) $li.="</a>";
   $li.="</li>\n";
  }//foreach

  $ul="<ul class='".$ulcls."'>\n".$li."</ul>\n";
  //$ul.="<div class='clr'></div>";
  return $ul;
 }//getHtmlLinList

 //---------------------------------------------------------//
 // アイテム画像を追加するHTMLを作成
 // 返り値:<a>
 //---------------------------------------------------------//
 public function getHtmlImageList($data,$datanum=null){
  $imgdir="../../img/";
  $html="";
  $i=0;
  foreach($data["data"] as $key=>$val){
   //大枠作成
   $html.="<div class='itemdiv'>\n";

   //imgタグ作成
   $imgpath=$imgdir.$val["jcode"].".jpg";
   $html.="<div class='itemimgdiv'>";
   if(file_exists($imgpath)){
    $html.="<img src=".$imgpath.">\n";
    //$html.="<input name='sakujyo' type='button' value='削除'>\n";
   }//if
   $html.="</div>\n";

   //商品情報生成
   $html.="<div class='itemclscode'>".$val["clscode"]."</div>\n";
   $html.="<div class='itemjcode'>".$val["jcode"]."</div>\n";
   $html.="<div class='itemsname'>".$val["sname"]."</div>\n";
   if($val["price"]){
    $html.="<div class='itemprice'><span>".$val["price"]."</span>円</div>\n";
   }
   $html.="<div class='itemlast'>".$val["lastsale"]."</div>\n";
   $html.="<input class='a' name='jan_".$val["jcode"]."' type='button' value='ファイルから'>\n";
   $html.="<input name='del_".$val["jcode"]."' type='button' value='削除'>\n";
   $html.="<input class='b' name='upload_".$val["jcode"]."' type='file' type='button'>\n";
   $html.="</div>\n";
  }//foreach
  return $html;
 }// getHtmlImageList
}//JANMAS

function SEARCHWORD($word){
 //右側にある余白を削除
 $w=rtrim($word);

 //クオートは削除
 $w=str_replace("'","",$w);

 //半角を全角へ変換
 $w=mb_convert_kana($w,"KS","UTF-8");
 
 //危険な文字を削除
 $patterns="/select|from|where|and|or|between|group|order|having|update|delete|truncate|drop|;/i";
 $w=preg_replace($patterns,"",$w);

 //空白で分割
 $w=explode("　",$w);
 return $w;
}
?>
