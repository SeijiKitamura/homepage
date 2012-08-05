<?php
require_once("./php/tirasi.class.php");
try{
//------------------------------------------------------------//
// データゲット
//------------------------------------------------------------//
 $db=new TIRASI();

 //引数セット
 $tirasi_id=$_GET["tirasi_id"];
 $hiduke=$_GET["hiduke"];
 $jcode=$_GET["jcode"];
 $lincode=$_GET["lincode"];

 //引数チェック
 if(! $tirasi_id ||! is_numeric($tirasi_id)){
  throw new exception("チラシ番号は数字で入力してください");
 }

 if(! $hiduke ||! CHKDATE($hiduke)){
  throw new exception("日付が不正です");
 }

 if(! $jcode ||! is_numeric($jcode)){
  throw new exception("JANコードが不正です");
 }

 $data=$db->getData($tirasi_id,$hiduke,$lincode,$jcode);
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
     <a href="index.html">
      <img src="./img/logo2.jpg" alt="スーパーキタムラ">
     </a>
    </div>
    <!-- logo -->

    <!-- hello -->
    <div class="hello">
     <h1>今週の広告</h1>
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
      <li>本日のおすすめ</li>
      <li> | </li>
      <li>今週のチラシ</li>
      <li> | </li>
      <li>今月のお買得品</li>
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
<?PHP
try{
 //単一チラシの日別掲載日を表示
 $html=$db->getHtmlDaysList($data["days"],$tirasi_id,$hiduke,$lincode);
 echo $html;
}
catch(Exception $e){
 $err[]=$e->getMessage();
}//catch
?>
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside">
<?php
try{
 $html=$db->getHtmlLinList($data["linlist"],$tirasi_id,$hiduke,$lincode);
 echo $html;
}//try
catch(Exception $e){
 $err[]=$e->getMessage();
}//catch
?>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
    <div class="tirasiitem">
<?php
$html=$db->getHtmlItem($data["nextitems"],"tirasiitem.php");
echo $html;
try{
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}//catch
?>
    </div>
    <!-- tirasiitem -->
   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
   
    <!-- tirasiitem -->
    <div class="tirasiitem">
<?php
//エラーがあれば処理終了
if($err && DEBUG){
 echo "<pre>";
 print_r($err);
 echo "</pre>";
 return false;
}//if

try{
 $html="";
 
 //単品表示
 $html.="<div id='tanpin'>";
 echo $html;
 
 $html=$db->getHtmlItem($data["item"],"tirasiitem.php");
 echo $html;
 echo "</div>\n";
 
 //同日、同一Lin商品
 $html=$db->getHtmlItem($data["linitems"],"tirasiitem.php");
 echo $html;
 
 if(DBBUG){
  echo "<pre>";
  print_r($data);
  echo "</pre>";
 }//if
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
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
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
