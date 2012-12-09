<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
require_once("./php/maillist.class.php");
require_once("./php/html.class.php");
try{
 //メール商品ゲット
 $db=new ML();
 //$db->saleday="2012/11/02";
 $db->getMailItem();
 $mailitem=$db->items["data"];
 $db->getDayList();
 $daylist=$db->items["data"];

 $db->set2osusume();
 $db->getMailItem();
 $osusume=$db->items["data"];
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
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
  <title>スーパーキタムラ:食品スーパーマーケット　</title>

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

<!--=======================wrapper start===============================-->
  <div id="wrapper">

<!--=======================header  start===============================-->
   <div id="header">

<!--=======================logo    start===============================-->
    <div class="logo">
     <a href="index.html">
      <img src="./img/logo2.jpg" alt="スーパーキタムラ">
     </a>
    </div>
<!--=======================logo    end  ===============================-->

<!--=======================hello   start===============================-->
    <div class="hello">
     <p>

     </p>
    </div>
<!--=======================hello   end  ===============================-->

<!--=======================mininavi start==============================-->
    <div class="mininavi">
     <ul>
      <li><a href="about.html">会社概要</a></li>
      <li><a href="access.html">アクセス</a></li>
      <li><a href="#">求人</a></li>
      <li><a href="sinsotu.html"> 新卒採用</a></li>
     </ul>
    </div>
<!--=======================mininavi end  ==============================-->

<!--=======================timesale start==============================-->
    <div class="timesale">
     <ul>
      <li><a href='index.php'>ホーム</a></li>
      <li> | </li>
      <li><a href='tirasiitem.php'>今週のチラシ</a></li>
      <li> | </li>
      <li><a href="calendar.php">カレンダー</a></li>
      <li> | </li>
      <li><a href="item.php">商品のご案内</a></li>
      <li> | </li>
      <li>メール商品</li>
      <li> | </li>
      <li>サービス</li>
     </ul>
    </div>
<!--=======================timesale end  ==============================-->
     
   <div class="clr"></div>
   </div>
<!--=======================header  end  ===============================-->

<!--=======================navi start    ==============================-->
   <div id="navi">
   </div>
<!--=======================navi end      ==============================-->

<!--=======================leftside start==============================-->
   <div id="leftside">
<?php
$html="";
$html.="<ul class='group'>";
foreach ($daylist as $rownum =>$rowdata){
 $html.="<li>";
 if(strtotime($rowdata["saleday"])!=strtotime($db->saleday)){
  $html.="<a href='?".$db->saleday."'>";
  $html.=date("m月d日",strtotime($rowdata["saleday"]))."(".$rowdata["cnt"].")";
  $html.="</a>";
 }//if
 else{
  $html.=date("m月d日",strtotime($rowdata["saleday"]))."(".$rowdata["cnt"].")";
 }
 $html.="</li>";
}
$html.="</ul>";
$html.="<div class='clr'></div>";
echo $html;
?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================rightside start=============================-->
<!--=======================rightside end  =============================-->

<!--=======================main      start=============================-->
   <div id="main" style="width:780px;">
<?php
//----------------------------------------------------------------//
// メール表示
//----------------------------------------------------------------//
if($mailitem){
 echo "<h3> 本日のメール商品</h3>\n";
 $html=html::setitem($mailitem);
 echo $html;
}//if

if($osusume){
 echo "<h3> 本日のおすすめ商品</h3>\n";
 $html=html::setitem($osusume);
 echo $html;
}//if

if(! $mailitem && ! $osusume){
 echo date("H時i分")."現在、本日のメールはまだ配信されておりません";
}//if
?>
   </div>
<!--=======================main      end  =============================-->
   <div class="clr"></div>
<!--=======================footer    start=============================-->
   <div id="footer">
    <h1>footer</h1>
   </div>
<!--=======================footer    end  =============================-->

  </div>
<!--=======================wrapper end =================================-->
 </body>
</html>
