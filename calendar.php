<?php
require_once("./php/calendar.class.php");
try{
//------------------------------------------------------------//
// データゲット
// $data
//      ["item"]  ["data"]    JANコード指定時の単品データ
//                ["status"]  true false
//                ["local"]   日本語列名
//------------------------------------------------------------//

 //引数セット
 $nen=$_GET["nen"];
 $tuki=$_GET["tuki"];

 //引数チェック
 if($nen  && ! is_numeric($nen))  throw new exception("年が無効です");
 if($tuki && ! is_numeric($tuki)) throw new exception("月が無効です");

 //引数していなければ当月を表示
 if(! $nen)  $nen=date("Y");
 if(! $tuki) $tuki=date("n");

 //単品マスタ系データゲット
 $db=new CL();
 $db->getCalendarList();
 $data["lists"]=$db->items;

 $db->getCalendarItem($nen,$tuki);
 $data["items"]=$db->items;
 
 //ナビ表示

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
  <title><?php echo $nen; ?>年<?php echo $tuki;?>月 お買得カレンダー:食品スーパーマーケット　</title>

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
     <h2></h2>
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
      <li><a href='tirasi.php'>今週のチラシ</a></li>
      <li> | </li>
      <li>カレンダー</li>
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
      <h2>一覧</h2>
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
   <div id="leftside">
<?php
$html=$db->getHtmlCalList($data["lists"],$nen,$tuki);
echo $html;
?>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
<?php
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

    <!-- calendaritem -->
    <div class="calendaritem">
    <h2><?php echo $nen."年".($tuki*1)."月"; ?>のお買得情報！！</h2>
<?php
$html=$db->getHtmlCalItem($data["items"],$nen,$tuki);
echo $html;
?>
     <div class='clr'></div>
    </div>
    <!-- calendaritem -->

    <!-- tirasiitem -->
    <div class="tirasiitem">
     <!-- tanpin -->
     <div id="tanpin">
<?php
?>
     </div>
     <!-- tanpin -->


     <!-- janmas -->
     <div class='janmas'>
      <div class='clr'></div>
     </div>
     <!-- janmas -->

    </div>
    <!-- tirasiitem -->
   <p>
   ご注意:<br />
   表示しているセールにつきましては予告なく変更、中止となる場合がございます。表示されておりますセールが当日実施されなかった場合、誠に恐れ入りますが店頭で販売しております価格を優先とさせていただきます。
   </p>
   </div>
   <!-- main -->

   <div class="clr"></div>
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
<?php
//if(DEBUG){
// echo "<pre>";
// print_r($data);
// echo "</pre>";
//}
?>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
