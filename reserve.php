<?php
require_once("./php/reserve.class.php");

try{
//------------------------------------------------------------//
// データゲット
// $data
//     ["grp1"]   ["data"]    グループ1一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["grp2"]   ["data"]    グループ2一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["grp3"]   ["data"]    グループ3一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//    ["itemlist"]["data"]    商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//------------------------------------------------------------//

 //引数セット
 $grp1=$_GET["grp1"];
 $grp2=$_GET["grp2"];
 $grp3=$_GET["grp3"];
 $jcode=$_GET["jcode"];

 //引数チェック
 if($grp1 && ! is_numeric($grp1)){
  throw new exception("グループは数字で入力してください");
 }

 if($grp2 && ! is_numeric($grp2)){
  throw new exception("グループは数字で入力してください");
 }

 if($grp3 && ! is_numeric($grp3)){
  throw new exception("グループは数字で入力してください");
 }

 if($jcode && ! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください");
 }

 $db=new RS();

 //grp1リストゲット
 $db->getGrp1();
 $data["grp1list"]=$db->items;

 //grp2リストゲット
 $db->getGrp2($grp1);
 $data["grp2list"]=$db->items;

 //grp3リストゲット
 $db->getGrp3($grp2);
 $data["grp3list"]=$db->items;

 //商品リストゲット
 $db->getItemsList($grp1,$grp2,$gpr3);
 $data["itemlist"]=$db->items;

 //単品ゲット
 if($jcode){
  $db->getItemsList($grp1,$grp2,$gpr3,$jcode);
  $data["item"]=$db->items;
 }
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
  <title>商品のご案内:食品スーパーマーケット　</title>

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
     <h1>商品のご案内</h1>
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
      <li><a href="index.html">ホーム</a></li>
      <li> | </li>
      <li><a href='tirasi.php'>今週のチラシ</a></li>
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
      <h2>グループ一覧</h2>
    </div>
    <!-- allcate -->

    <!-- search -->
    <div id="search">
<?php
?>
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside" style="margin:0px !important;">
<?PHP
foreach($data["grp1list"]["data"] as $rownum =>$row){
 $html.="<li>";
 if($grp1!==$row["grp1"]){
  $html.="<a href='reserve.php?grp1=".$row["grp1"]."'>";
 }
 $html.=$row["grp1name"];
 if($grp1!==$row["grp1"]){
  $html.="</a>";
 }
 $html.="</li>\n";
}//foreach
echo "<ul>\n".$html."</ul>\n";
?>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside" style="float:left !important;margin:0 2px !important;">
<?php
$html="";
foreach($data["grp2list"]["data"] as $rownum =>$row){
 $html.="<li>";
 if($grp2!==$row["grp2"]){
  $html.="<a href='reserve.php?grp1=".$grp1."&grp2=".$row["grp2"]."'>";
 }
 $html.=$row["grp2name"];
 if($grp2!==$row["grp2"]){
  $html.="</a>";
 }
 $html.="</li>\n";
}//foreach
echo "<ul>\n".$html."</ul>\n";
?>
    <!-- tirasiitem-->
    <div class="tirasiitem">
    </div>
    <!-- tirasiitem-->

   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
<?php
//エラーがあれば処理終了
if($err && DEBUG){
 echo "<pre>";
 print_r($err);
 echo "</pre>";
 return false;
}
?>

    <!-- calendar -->
    <div class="calendaritem">
    </div>
    <!-- calendar -->

    <!-- tirasiitem -->
    <div class="tirasiitem">
     <!-- tanpin -->
     <div id="tanpin">
<?php
//単品表示
if($data["item"]["data"]){
 $val=$data["item"]["data"][0];
 $html="";
 $html.="<a href=''>";
 $html.="<div class='imgdiv'><img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'></div>\n";
 $html.="<div class='makerdiv'>".$val["maker"]."</div>\n";
 $html.="<div class='snamediv'>".$val["sname"]."</div>\n";
 $html.="<div class='baikadiv'>";
 if($val["baika"]) $html.="<span>".$val["baika"]."</span>";
 if(preg_match("/^[0-9]+$/",$val["baika"]) && $val["baika"]) $html.="円";
 $html.="</div>\n";
 $html.="<div class=''>".$val["notice"]."</div>\n";
 $html.="<div class='jcodediv'>JAN:".$val["jcode"]."</div>\n";
 $html.="</a>";
 echo $html;
}
?>
     </div>
     <!-- tanpin -->


     <!-- janmas -->
     <div class='janmas'>
<?php
//アイテム一覧表示
$html="";
foreach($data["itemlist"]["data"] as $rownum => $val){
 $url="reserve.php?grp1=".$grp1."&grp2=".$grp2."&grp3=".$grp3."&jcode=".$val["jcode"];
 $html.="<a href='".$url."'>";
 $html.="<div class='imgdiv'><img src='./img/".$val["jcode"].".jpg' alt='".$val["sname"]."'></div>\n";
 $html.="<div class='snamediv'>".$val["sname"]."</div>\n";
 $html.="<div class='baikadiv'>";
 if($val["baika"]) $html.="<span>".$val["baika"]."</span>";
 if(preg_match("/^[0-9]+$/",$val["baika"]) && $val["baika"]) $html.="円";
 $html.="</div>\n";
 $html.="<div class='jcodediv'>JAN:".$val["jcode"]."</div>\n";
 $html.="</a>";
}//foreach
echo $html;
?>
      <div class='clr'></div>
     </div>
     <!-- janmas -->

    </div>
    <!-- tirasiitem -->
   </div>
   <!-- main -->

   <!--div class="clr"></div-->
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
<?php
if(DEBUG){
 echo "<pre>";
 print_r($data);
 echo "</pre>";
}
?>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
