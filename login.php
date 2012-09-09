<?php
require_once("./php/auth.class.php");
try{
 //ログイン判定
 $cookie=$_COOKIE["kitamura"];
 $flg=false;
 if($cookie) $flg=true;
}//try
catch(Exception $e){
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
  <title>ログイン:スーパーキタムラ　食品スーパーマーケット　</title>

  <!-- link(ページごとに変更) -->
  <link rel="icon" href="./img/kitamura.ico" type="type/ico" sizes="16x16" /> 
  <link rel="stylesheet" href="./css/kitamura.css" /> 
  <link rel="next" href="" /> <!-- 次のページ -->
  <link rel="prev" href=""/>  <!-- 前のページ -->

  <!-- スクリプト(全ページ共通) -->
  <script type="text/javascript" src="./js/jquery.js"></script>
  <script type="text/javascript" src="./js/jquery.cookie.js"></script>

  <script>
$(function(){
 //ログイン判定
 checkCookie();

 $("a.login").bind("click",function(){
  login();
 });//$("#login").bind("click",function(){

 $("a.logout").bind("click",function(){
  logout();
 });//$("#logout").bind("click",function(){
});

//--------------------------login--------------------------------------//
function login(){
 var url="./php/jsonGetUser.php";
 var data={"mail":$("#mail").val(),
           "pass":$("#password").val()};
 //値チェック
 if(! checkMail($("#mail"))) return false;
 if(! checkPass($("#password"))) return false;

 //ログイン処理
 $.post(url,data,function(html){
  if(html.match(/エラー/)){
   alert(html);
   return false;
  }//if(html.match(/エラー/)){
   
  //クッキーをセット
  $.cookie("kitamura",html,{ expires:1});

  //ページ移動
  window.location.href="index.html";

 },"html");//$.post(url,data,function(){
}
//--------------------------login--------------------------------------//

//--------------------------logout-------------------------------------//
function logout(){
 if(! confirm("ログアウトしますか")) return false;

 //クッキーを削除
 $.cookie("kitamura",null);

 //
 alert("ログアウトしました");
 window.location.href="index.html";
}
//--------------------------logout-------------------------------------//

//--------------------------checkMail----------------------------------//
function checkMail(elem){
 $("dd.msg").empty();
 var v=elem.val();
 console.log(v);
 if(! v || ! v.match(/[@]/)){
  elem.after("<dd class='msg'>メールアドレスを確認してください</dd>");
  return  false;
 }//if(! v || ! v.match(/[@]/)){
 return true;
}
//--------------------------checkMail----------------------------------//

//--------------------------checkPass----------------------------------//
function checkPass(elem){
 $("dd.msg").empty();
 var v=elem.val();
 if(! v || ! v.match(/^[0-9a-zA-z]+$/)){
  elem.after("<dd class='msg'>パスワードを確認してください</dd>");
  return false;
 }//if(! v || ! v.match(/^[0-9a-zA-z]+$/)){
 return true;
}
//--------------------------checkPass----------------------------------//

//--------------------------checkCookie--------------------------------//
function checkCookie(){
 var flg=true;
 if(! $.cookie("kitamura")) flg=false;

 //ログイン判定
 if(flg){
  //メールアドレス等非表示
  $("#leftside dl dt:lt(2)").empty();
  $("#leftside dl dd:lt(3)").empty();
 }//if
 else{
  //ログアウト非表示
  $("#leftside dl dd:eq(3)").empty();
 }//else
}//function checkCookie(){
//--------------------------checkCookie--------------------------------//

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
     <h1>ログイン</h1>
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
    <dl>
     <dt><label for="mail">メールアドレス:</label></dt>
     <dd><input id ="mail" type="mail" value=""></dd>
     <dt><label for="password">パスワード:</label></dt>
     <dd><input id ="password" type="password" value=""></dd>
     <dd><a class="login">ログイン</a></dd>
     <dd><a class="logout">ログアウト</a></dd>
    </dl>
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
      <p>
      </p>

     </div>
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
