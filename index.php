<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
require_once("./php/maillist.class.php");
require_once("./php/html.class.php");
try{
 //分類グループゲット
 $db=new JANMAS();
 $db->getLinList();
 $grp=$db->items["data"];

 //新商品データゲット
 $db->getNewItem();
 $newitem=$db->items["data"];
 
 //チラシ商品ゲット
 $db=new TIRASI();
 $db->flg0="734";
 $db->saleday="2012/11/29";
 $db->getItemList();
 $tirasi=$db->items["data"];

 //メール商品ゲット
 $db=new ML();
 $db->saleday="2012/11/02";
 $db->getMailItem();
 $mailitem=$db->items["data"];

//カレンダーゲット
 $db=new CL();
 $db->saleday="2012/11/21";
 $db->getCalendar();
 $cal=$db->items["data"];

 
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
      <li>ホーム</li>
      <li> | </li>
      <li><a href='tirasiitem.php'>今週のチラシ</a></li>
      <li> | </li>
      <li><a href="calendar.php">カレンダー</a></li>
      <li> | </li>
      <li><a href="item.php">商品のご案内</a></li>
      <li> | </li>
      <li><a href="mailitem.php">メール商品</a></li>
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
$html=html::setgroup($grp,"item.php?lincode=","lincode","linname");
//taniとnoticeを除外
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


//----------------------------------------------------------------//
// 広告の品表示
//----------------------------------------------------------------//
if($tirasi){
 echo "<h3>広告の品</h3>";

 //5アイテムに絞る
 $item=null;
 $j=0;
 for($i=0;$i<count($tirasi);$i++){
  $j++;
  if($j>5) break;
  $item[]=$tirasi[$i];
 }
 $html=html::setitemTirasi($item);
 echo $html;

 if(count($newitem)>5){
  echo "and more!";
 }//if
}//if

//----------------------------------------------------------------//
// メール表示
//----------------------------------------------------------------//
if($mailitem){
 echo "<h3> 本日のメール商品</h3>\n";
 //5アイテムに絞る
 $item=null;
 $j=0;
 for($i=0;$i<count($mailitem);$i++){
  $j++;
  if($j>5) break;
  $item[]=$mailitem[$i];
 }
 $html=html::setitem($item);
 echo $html;

 if(count($newitem)>5){
  echo "and more!";
 }//if
}//if

//----------------------------------------------------------------//
// 新商品表示
//----------------------------------------------------------------//
if($newitem){
 echo "<h3>新商品のご案内</h3>\n";
 $j=0;
 $item=null;
 //10アイテムに絞る
 for($i=0;$i<count($newitem);$i++){
  $j++;
  if($j>10) break;
  $item[]=$newitem[$i];
 }//for
 $html=html::setitem($item);
 $html=preg_replace("/<div class='tani'>.*<\/div>/","",$html);
 $html=preg_replace("/<div class='notice'>.*<\/div>/","",$html);
 echo $html;
 
 if(count($newitem)>10){
  echo "and more!";
 }//if
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
