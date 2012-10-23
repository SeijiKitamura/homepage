<?php
require_once("./php/auth.class.php");
try{
 //クッキー存在チェック
 $c=$_COOKIE["kitamura"];
 if($c){
  //クッキーを配列化
  $c=explode(":",$c);
  $cookie["usermail"]=$c[0];
  $cookie["checkcode"]=$c[1];

  //クッキー有効を確認
  $db=new AUTH();
  $db->getAuth($cookie["usermail"],$cookie["checkcode"]);
  $user=$db->items[0];
  print_r($user);
  print_r($cookie);
 }//if
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
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
 $("form#login_logout").submit(function(){
  if($(this).find("input[name=login]").length){
   if(! checkMail($("input[id=usermail]"))) return false;
   if(! checkPass($("input[id=password]"))) return false;
   console.log("login");
   //ログイン認証
   var url="./php/getLoginPass.php";
   var data={"usermail":$("input[id=usermail]").val(),
             "password":$("input[id=password]").val()
            };
   console.log(data);
   $.post(url,data,function(html){
    //エラーチェック
    if(html.match(/エラー/)){
     $("input[id=password]").parent()
                            .find("span")
                            .text("パスワードが違います");
     return false;
    }
    //クッキーセット
    $.cookie("kitamura",html,{path:"/",expires:1});
    console.log(html);
    window.location.href="index.html";
   });//$.post(url,data,function(html){
  }//if
  else if($(this).find("input[name=logout]").length){
   console.log("logout");
   //クッキー削除
   $.cookie("kitamura","",{path:"/",expires:-1});
   alert("ログアウトしました");
   window.location.href="index.html";
  }//else

  //画面遷移キャンセル
  return false;
 });// $("form#login_logout").submit(function(){
 
 $("a.forget").click(function(){
  //メールアドレスチェック
  if(! checkMail($("input[id=usermail]"))) return false;
  var usermail=$("input[id=usermail]").val();
  $("form#forgetpass").append("<input name='usermail' type='text' value='"+usermail+"'>");
  $("form#forgetpass").submit();
 });
});

//--------------------------checkMail----------------------------------//
function checkMail(elem){
 var v=elem.val();
 var msg="メールアドレスを確認してください";
 elem.parent().find("span").text("");
 if(! v || ! v.match(/[@]/)){
  elem.parent().find("span").text(msg);
  return  false;
 }//if(! v || ! v.match(/[@]/)){
 return true;
}
//--------------------------checkMail----------------------------------//

//--------------------------checkPass----------------------------------//
function checkPass(elem){
 var v=elem.val();
 var msg="パスワードを確認してください";
 elem.parent().find("span").text("");
 if(! v || ! v.match(/^[0-9a-zA-z]+$/)){
  elem.parent().find("span").text(msg);
  return false;
 }//if(! v || ! v.match(/^[0-9a-zA-z]+$/)){
 return true;
}
//--------------------------checkPass----------------------------------//


/*
//--------------------------forget-------------------------------------//
function forget(){
 var url="./checkmail.php";
 var data={"usermail":$("#mail").val()};
 if(! checkMail($("#mail"))) return false;
 $.post(url,data,function(html){
  //エラーチェック
  if(html.match(/エラー/)){
   alert(html);
   return false;
  }//if(html.match(/エラー/)){
  
  window.location.href="./checkmail.php";
 });//$.post(url,data,function(html){
}
//--------------------------forget-------------------------------------//

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

//--------------------------checkCookie--------------------------------//
function checkCookie(){
 var flg=true;
 if(! $.cookie("kitamura")) flg=false;

 //ログイン判定
 if(flg){
  //メールアドレス等非表示
  $("#leftside dl dt:lt(2)").empty();
  $("#leftside dl dd:lt(3)").empty();
  $("#leftside dl dd:lt(4)").empty();
 }//if
 else{
  //ログアウト非表示
  $("#leftside dl dd:eq(3)").empty();
 }//else
}//function checkCookie(){
//--------------------------checkCookie--------------------------------//
*/
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
      <dl>
       <form id="login_logout" method="post" action="./index.html">
<?php
 if(! $user){
  echo "<dt><label for='usermail'>メールアドレス:</label></dt>";
  echo "<dd><input id ='usermail' type='text' value=''><span></span></dd>";
  echo "<dt><label for='password'>パスワード:</label></dt>";
  echo "<dd><input id ='password' type='password' value=''><span></span></dd>";
  echo "<dt></dt>";
  echo "<dd><input name='login' type='submit' value='ログイン' /></dd>\n";
  echo "<dt></dt>";
 }//if
 else if($user){
  echo "<dt></dt>";
  echo "<dd>".$user["name"]."さんでログイン中....</dd>";
  echo "<dt></dt>";
  echo "<dd><input name='logout' type='submit' value='ログアウト' /></dd>\n";
 }//else
?>
       </form>
       <form id="forgetpass" method="post" action="checkmail.php">
<?php
  echo "<dt></dt>";
  echo "<dd><a class='forget' href='#'>パスワードを忘れた</a></dd>\n";
?>
       </form>
      </dl>
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
