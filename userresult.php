<?php
require_once("./php/auth.class.php");
try{
 if($_POST){
  //POSTを配列へ変換
  $cookie=$_POST;
 }//if
 else if($_COOKIE){
  //Cookieを配列へ変換
  $ary=$_COOKIE["kitamura"];
  $ary=explode(",",$ary);
  foreach($ary as $key=>$val){
   $s=explode(":",$val);
   $cookie[$s[0]]=$s[1];//Cookie
  }//foreach
 }//else if
 else{
  throw new exception("お客様情報を登録してください");
 }

 //Cookieを一旦削除
 setcookie("kitamura",0,time()-3600);
 //setcookie("kitamura",$cookie["usermail"],time()+86400,"/");

 //メッセージセット
 $msg="以下の内容で登録が完了しました。ありがとうございました。";

 //登録
 $db=new AUTH();
 $db->UserAdd($cookie);
 $user=$db->items[0];

 //Cookieをセット
 setcookie("kitamura",$user["usermail"].":".$user["checkcode"],time()+86400,"/");
}//try
catch(Exception $e){
 $msg="エラー:".$e->getMessage();

 //Cookieを再セット
 setcookie("kitamura","",0,"/");
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
  <title>登録結果:スーパーキタムラ　食品スーパーマーケット　</title>

  <!-- link(ページごとに変更) -->
  <link rel="icon" href="./img/kitamura.ico" type="type/ico" sizes="16x16" /> 
  <link rel="stylesheet" href="./css/kitamura.css" /> 
  <link rel="next" href="" /> <!-- 次のページ -->
  <link rel="prev" href=""/>  <!-- 前のページ -->

  <!-- スクリプト(全ページ共通) -->
  <script type="text/javascript" src="./js/jquery.js"></script>
  <script type="text/javascript" src="./js/jquery.cookie.js"></script>
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
     <h1>登録結果</h1>
    </div>
    <!-- hello -->

    <!-- mininavi -->
    <div class="mininavi">
     <ul>
     </ul>
    </div>
    <!-- mininavi -->

    <!-- timesale -->
    <div class="timesale">
     <ul>
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
      <h2></h2>
    </div>
    <!-- allcate -->

    <!-- search -->
    <div id="search">
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside" style="margin:0px !important;">
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
    <!-- tirasiitem-->
    <div class="tirasiitem">
    </div>
    <!-- tirasiitem-->

   </div>
   <!-- rightside -->

   <!-- main -->
    <div id="main">
     <div class="entry">
      <p><?php echo $msg; ?></p>

      <dl>
       <dt>メールアドレス:</dt>
       <dd id="usermail"><div><?php echo $cookie["usermail"]; ?></div></dd>
       <div class='clr'></div>
       <dt>お名前:</dt>
       <dd id="name"><div><?php echo $cookie["name"]; ?></div></dd>
       <div class='clr'></div>
       <dt>電話番号:</dt>
       <dd id="tel"><div><?php echo $cookie["tel"]; ?></div></dd>
       <div class='clr'></div>
       <dt>ご住所:</dt>
       <dd id="address" ><div><?php echo $cookie["address"]; ?></div></dd>
       <div class='clr'></div>
      </dl>

     </div>
    <!-- entry -->

    <!-- calendar -->
    <div class="calendaritem">
    </div>
    <!-- calendar -->

    <!-- tirasiitem -->
    <div class="tirasiitem">
     <!-- tanpin -->
     <div id="tanpin">
     </div>
     <!-- tanpin -->


     <!-- janmas -->
     <div class='janmas'>
     </div>
     <!-- janmas -->

    </div>
    <!-- tirasiitem -->
   </div>
   <!-- main -->
   <div class="clr"></div>
   <!--div class="clr"></div-->
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
