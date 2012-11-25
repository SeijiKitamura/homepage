<?php
require_once("./php/janmas.class.php");
require_once("./php/auth.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
try{
 //分類グループゲット
 $db=new JANMAS();
 $db->getLinMas();
 $grp=$db->items;

 //新商品データゲット
 $db->getNewItem();
 $newitems=$db->items;

 //Cookieチェック
 if($_COOKIE["kitamura"]){
  $c=explode(":",$_COOKIE["kitamura"]);
  $mail=$c[0];
  $pass=$c[1];
 }//if
 
 //ユーザー名ゲット
 if($mail && $pass){
  $db=new AUTH();
  $db->getAuth($mail,$pass);
  $username=$db->items[0]["name"];
 }//if

 //カレンダーゲット
 //$hiduke=date("Y-m-d",strtotime("2012/10/5"));
 $hiduke=date("Y-m-d");
 $db=new CL();
 $db->getItem($hiduke);
 $cal=$db->item;

 //チラシゲット
 $db=new TIRASI();
 $db->getTitleList($hiduke);
 $title=$db->items["data"][0]; //直近のチラシタイトル
 $db->getItemList($title["tirasi_id"],null,null,null);
 $items=count($db->items["data"]); //チラシ掲載商品数
 
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
  <!-- wrapper -->
  <div id="wrapper">

   <!-- header -->
   <div id="header">

    <!-- logo -->
    <div class="logo">
     <a href="index.html">
      <img src="./img/logo2.jpg" alt="スーパーキタムラ">
     </a>
    </div>
    <!-- logo -->

    <!-- hello -->
    <div class="hello">
     <p>

     </p>
    </div>
    <!-- hello -->

    <!-- mininavi -->
    <div class="mininavi">
     <ul>
      <li><a href="login.php">
<?php
 if($username) echo $username."さん";
 else echo "ログイン";
?>
       </a></li>
      <li><a href="about.html">会社概要</a></li>
      <li><a href="access.html">アクセス</a></li>
      <li><a href="#">求人</a></li>
      <li><a href="sinsotu.html"> 新卒採用</a></li>
     </ul>
    </div>
    <!-- mininavi -->

    <!-- timesale -->
    <div class="timesale">
     <ul>
      <li>ホーム</li>
      <li> | </li>
      <li><a href='tirasi.php'>今週のチラシ</a></li>
      <li> | </li>
      <li><a href="calendar.php">カレンダー</a></li>
      <li> | </li>
      <li><a href="item.php?lincode=1">商品のご案内</a></li>
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
   </div>
   <!-- navi -->

   <!-- leftside -->
   <div id="leftside">
    <ul class="grouplist">
<?php
//グループ表示
foreach($grp["data"] as $key=>$row){
 echo "<li>";
 echo "<a href='item.php?lincode=".$row["lincode"]."'>";
 echo $row["linname"];
 echo "</a>";
 echo "</li>\n";
}//foreach
?>
    </ul>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
    <!-- koukoku -->
    <div class="event">
     <h4>広告のご案内</h4>
<?php
//ここに広告のページへtirasi_idを引数にしたリンクを挿入

$sday=date("n月j日",strtotime($title["hiduke"]));
$eday=date("n月j日",strtotime($title["view_end"]));
echo "<div class='tirasi_kikan'>".$sday."から".$eday."まで</div>\n";
echo "<div class='tirasi_title'>".$title["title"]."</div>\n";
echo "<div class='tirasi_items'>合計".$items."点掲載</div>\n";
?>
    </div>
    <!-- koukoku -->


    <!-- calendar -->
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
    <!-- calendar -->

   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
    <div class="janmas">
     <h3>新商品のご案内</h3>
<?php
//新商品(NEWITEM :confing.php内に記述)
$i=0;
if(count($newitems["data"])>NEWITEM){
 for($i=0;$i<NEWITEM;$i++){
  $nitems["data"][$i]=$newitems["data"][$i];
 }//for
}//if
else $nitems["data"]=$newitems["data"];
$nitems["status"]=$newitems["status"];
$items["local"]=$newitems["local"];

$db=new JANMAS();
$html=$db->getHtmlJanMas($nitems);
echo $html;
?>
    </div>
    <!-- event -->
    <div class="event">
     event1
    </div>
    <!-- event -->

    <!-- event -->
    <div class="event">
     event2
    </div>
    <!-- event -->

    <!-- event -->
    <div class="event">
     event3
    </div>
    <!-- event -->

    <!-- event -->
    <div class="event">
     event4
    </div>
    <!-- event -->
   </div>
   <!-- main -->

   <div class="clr"></div>
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
