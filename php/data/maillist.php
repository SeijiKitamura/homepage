<?php
try{
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
  <link rel="stylesheet" href="../../css/kitamura.css" /> 
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
      <img src="../../img/logo2.jpg" alt="スーパーキタムラ">
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
   </div>
   <!-- navi -->

   <!-- leftside -->
   <div id="leftside">
    <ul id="lingroup">
<?php
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
?>
    </div>
    <!-- koukoku -->


    <!-- calendar -->
    <div class="event">
    <a href="calendar.php" target="_blank">
<?php
?>
    </a>
    </div>
    <!-- calendar -->

   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">

    <!-- event -->
    <div class="event">
     event1
    </div>
    <!-- event -->

    <!-- event -->
    <div class="entry">
     <form id="touroku" method="POST" action="setmaillist.php">
      <dl>
       <dt><label for="hiduke">日付:</label></dt>
       <dd><input id="hiduke" name="hiduke" type="text"></dd>
       <dt><label for="mailtitle">タイトル:</label></dt>
       <dd><input id="mailtitle" name="mailtitle" type="text"></dd>
       <dt><label for="mailmain">本文:</label></dt>
       <dd><textarea id="mailmain" name="mailmain"></textarea></dd>
       <dt></dt>
       <dd><input name="btn" type="submit" value="登録" /></dd>
      </dl>
     </form>
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
