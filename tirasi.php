<?php
require_once("./php/tirasi.class.php");
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");

try{
//------------------------------------------------------------//
// データゲット
// $data["titles"]["data"]    チラシ投函日日程一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["title"] ["data"]    指定チラシのタイトル、日程
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["days"]  ["data"]    単一チラシ日程
//                ["status"]  true false
//                ["local"]   日本語列名
//   ["allitems"] ["data"]    チラシ全体の商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["items"] ["data"]    指定日の商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["item"]  ["data"]    JANコード指定時の単品データ
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["linlist"]["data"]    指定日のラインリスト、アイテム数
//                ["status"]  true false
//                ["local"]   日本語列名
//   ["nextitems"]["data"]    翌日の商品リスト
//                ["status"]  true false
//                ["local"]   日本語列名
//------------------------------------------------------------//
 //引数セット
 //$tirasi_id=$_GET["tirasi_id"];
 //$hiduke=$_GET["hiduke"];
 //$jcode=$_GET["jcode"];
 $lincode=$_GET["lincode"];
 
 //引数チェック
// if($tirasi_id && ! is_numeric($tirasi_id)){
//  throw new exception("チラシ番号は数字で入力してください");
// }

 if($hiduke && ! CHKDATE($hiduke)){
  throw new exception("日付が不正です");
 }
 
 if($lincode && ! is_numeric($lincode)){
  throw new exception("部門番号が不正です");
 }

 //チラシタイトルゲット
 $db=new TIRASI();
 $db->getTitleList($hiduke);
 $title=$db->items;
 if(! $tirasi_id) $tirasi_id=$title["data"][0]["tirasi_id"];
 if(! $hiduke){    
  $hiduke=$title["data"][0]["hiduke"];
  if(strtotime($hiduke)<strtotime(date("Y-m-d"))){
   $hiduke=date("Y-m-d");
  }//if
 }//if
 
 //チラシアイテムゲット(単品)
 if($jcode){
  $db->getItemList($tirasi_id,$hiduke,$lincode,$jcode);
  $item=$db->items;
 }//if

 //チラシアイテムゲット(一覧)
 $db->getItemList($tirasi_id,$hiduke,$lincode);
 $items=$db->items;

 //Linリストゲット
 $db->getLinList($tirasi_id,$hiduke);
 $lin=$db->items;

 //カレンダーゲット
 $db2=new CL();
 $db2->getItem($hiduke);
 $cal=$db2->item;

/*
 if($lincode){
  //単品マスタ系データゲット
  $db2=new JANMAS();
  //$db2->getLinItems($data["items"]["data"][0]["jcode"]);
  $db2->getJanMas($lincode,0,0,0);
  $data["jlinitems"]=$db2->items;
 }
 echo "success";
*/
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}//catch
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="ja">
 <head>
  <!-- META系(全ページ共通) -->
  <meta http-equiv="Content-language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta name="ROBOTS" content="index,follow">
  <meta name="description" content="東京都大田区南馬込にある食品スーパーマーケット、スーパーキタムラの公式サイト。年中無休、営業時間AM9:30-PM10:00。">
  <meta name="keywords" content="キタムラ,スーパーキタムラ,スーパーきたむら,スーパー北村,シェノール,惣菜,パン,お酒,日本酒,焼酎,ワイン,配達">

  <!-- タイトル(ページごとに変更) -->
  <title>今週のチラシ:食品スーパーマーケット　</title>

  <!-- link(ページごとに変更) -->
  <link rel="icon" href="./img/kitamura.ico" type="type/ico" sizes="16x16" /> 
  <link rel="stylesheet" href="./css/kitamura.css" /> 
  <link rel="next" href="" /> <!-- 次のページ -->
  <link rel="prev" href=""/>  <!-- 前のページ -->

  <!-- スクリプト(全ページ共通) -->
  <script type="text/javascript" src="./js/jquery.js"></script>
  <script>
  </script>
 </head>
 <body>
  <!-- wrapper -->
  <div id="wrapper">

   <!-- header -->
   <div id="header">

    <!-- logo -->
    <div class="logo">
     <a href="index.php">
      <img src="./img/logo2.jpg" alt="スーパーキタムラ">
     </a>
    </div>
    <!-- logo -->

    <!-- hello -->
    <div class="hello">
     <h1></h1>
    </div>
    <!-- hello -->

    <!-- mininavi -->
    <div class="mininavi">
     <ul>
      <li><a href="about.html">会社概要</a></li>
      <li><a href="access.html">アクセス</a></li>
      <li>求人</li>
      <li><a href="sinsotu.html"> 新卒採用</a></li>
     </ul>
    </div>
    <!-- mininavi -->

    <!-- timesale -->
    <div class="timesale">
     <ul>
      <li><a href="index.php">ホーム</a></li>
      <li> | </li>
      <li>今週のチラシ</li>
      <li> | </li>
      <li><a href="calendar.php">カレンダー</a></li>
      <li> | </li>
      <li><a href="item.php">商品のご案内</a></li>
      <li> | </li>
      <li>ご注文承り中</li>
      <li> | </li>
      <li>サービス</li>
     </ul>
    </div>
    <!-- timesale -->
     
   <div class="clr"></div>
   </div>
   <!-- header -->

   <!-- navi -->
   <div id="navi">
    <!-- allcate -->
    <div id="allcate">
      広告一覧
    </div>
    <!-- allcate -->

    <!-- search -->
    <div id="search">
<?php
//販売日リスト作成
$html=$db->getHtmlDaysList($data["days"],$tirasi_id,$hiduke,$lincode);
echo $html;
?>
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside">
    <ul class="grouplist">
     <li><a href="tirasi.php">すべて</a></li>
<?php
foreach ($lin["data"] as $rows=>$col){
 echo "<li>";
 echo "<a href='?lincode=".$col["lincode"]."'>";
 echo $col["linname"]."(".$col["cnt"].")"."</a>";
 echo "</li>\n";
}//foreach
?>
    </ul>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
    <!-- calendar-->
    <div class="event">
     <a href="calendar.php" target="_blank">
<?php
if($cal["data"]){
 $h=date("m月d日",strtotime($cal["data"]["hiduke"]));
 preg_match("/([^円倍割引]+)([円倍割引]+)/",$cal["data"]["rate"],$rate);
 echo "<h4>".$h."限り</h4>";
 echo "<div class='snamediv'>".$cal["data"]["title"]."</div>";
 echo "<div class='baikadiv'><span>".$rate[1]."</span>".$rate[2]."</div>";
 echo "<div class='noticediv'>".$cal["data"]["notice"]."</div>";
}//if
?>
     </a>

    </div>
    <!-- calendar-->
   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
    <div class="tirasiitem">
<?php
//エラーがあれば処理終了
if($err && DEBUG){
 echo "<pre>";
 print_r($err);
 echo "</pre>";
 return false;
}
//アイテム表示
$html=$db->getHtmlItem($items,"tirasiitem.php");
echo $html;
?>
     <!-- tirasiitem -->
     <div class='janmas'>
<?php
if($data["jlinitems"]){
 echo "<h4>こんな商品も売れています</h4>\n";
 $html=$db2->getHtmlJanMas($data["jlinitems"]);
 echo $html;
}
?>
     </div>
     <!-- janmas -->
<?php
if(DEBUG){
 echo "<pre>";
 print_r($data);
 echo "</pre>";
}
?>
    </div>
    <!-- tirasiitem -->

   </div>
   <!-- main -->

   <div class="clr"></div>
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
    <span style="font-size:12px;">
    掲載している商品は予定数量に到達次第、販売終了となります。
    また掲載している価格と店頭価格に差異があった場合には、店頭価格を優先させていただきます。
    </span>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
