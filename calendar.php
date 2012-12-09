<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
require_once("./php/maillist.class.php");
require_once("./php/html.class.php");
try{
 $saleyear =$_GET["saleyear"];
 $salemonth=$_GET["salemonth"];

//引数チェック
 
//カレンダーゲット
 $db=new CL();
 if($saleyear && $salemonth){
  $db->saleday=$saleyear."-".$salemonth."-1";
 }
 //$db->saleday="2012/11/21";
 $db->getCalendar();
 $cal=$db->items["data"];
 $db->getItemList();
 $calitem=$db->items["data"];
 //当月のカレンダー日数
 $db->getMonthCount();
 $monthcal[]=$db->items["data"];

 //翌月のカレンダー日数
 $db->saleday=date("Y-m-d",strtotime("1month",strtotime($db->saleday)));
 $db->getMonthCount();
 $monthcal[]=$db->items["data"];
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
     <a href="index.php">
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
      <li>カレンダー</a></li>
      <li> | </li>
      <li><a href='item.php'>商品のご案内</a></li>
      <li> | </li>
      <li><a href='mailitem.php'>メール商品</a></li>
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
$html ="<ul class='group'>";
$html.="<li>";
$html.=$monthcal[0]["nen"]."年".$monthcal[0]["tuki"]."月";
$html.="(".$monthcal[0]["cnt"].")";
$html.="</li>\n";
if($monthcal[1]["cnt"]>0){
 $html.="<li><a href='?saleyear=".$monthcal[1]["nen"]."&salemonth=".$monthcal[1]["tuki"]."'>\n";
 $html.=$monthcal[1]["nen"]."年".$monthcal[1]["tuki"]."月";
 $html.="(".$monthcal[1]["cnt"].")";
 $html.="</a></li>\n";
}
$html.="</ul>";
$html.="<div class='clr'></div>\n";
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
// カレンダー情報
//----------------------------------------------------------------//
if($cal){
 echo "<h4>本日のカレンダー情報:\n";
 $j=0;
 $item=null;
 $html=$cal[0]["sname"]." ".$cal[0]["price"]."</h4>\n";
 echo $html;
}//if
$html=html::setcalendar($calitem);
echo $html;
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
