<?php
require_once("./php/auth.class.php");
try{
 $db=new AUTH();
 if($_GET["auth"]){
  //GETが有効ならcheckcodeからユーザー情報を取得
  $md5=$_GET["auth"];
  $db->checkMD5($md5);
  $user=$db->items;
 }//if
 else{
  //COOKIEからユーザー情報をゲット
  $c=$_COOKIE["kitamura"];
  $c=explode(":",$c);
  $cookie["usermail"]=$c[0];
  $cookie["checkcode"]=$c[1];
  if(! $cookie["usermail"] || ! $cookie["checkcode"]) throw new exception("再ログインが必要です");

  $db->getAuth($cookie["usermail"],$cookie["checkcode"]);
  $user=$db->items[0];
 }
 if(! $user) throw new exception("メールアドレスが未登録です");
}//try
catch(Exception $e){
 $msg="エラー:".$e->getMessage();
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
  <title>お客様情報登録:スーパーキタムラ　食品スーパーマーケット　</title>

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

 $("input[id='password2']").change(function(){ checkPass(); });
 $("input[id='name']").blur(function(){ checkName(); });
 $("input[id='tel']").blur(function(){ checkTel(); });

 $("form").submit(function(){
  if(! sendData()) return false;
 });

});//$(function()

function checkPass(){
 var pass1=$("input[id='password']");
 var pass2=$("input[id='password2']");
 var flg=true;
 var msg="";
 //空欄チェック
 if(! pass1.val() || ! pass2.val()){
  msg="パスワードが空欄です";
  flg=false;
 }//if
 
 //同一チェック
 if(pass1.val()!==pass2.val()){
  msg="パスワードが不一致です";
  flg=false;
 }//if

 //桁数チェック
 if(pass1.val().length<3 || pass2.val().length<3){
  msg="3文字以上のパスワードを入力してください";
  flg=false;
 }//if
 
 //禁則文字チェック
 var pattern=/^[0-9a-zA-Z]+$/;
 if(! pass1.val().match(pattern)){
  msg="半角英数字のみを使用してパスワードを入力してください";
  flg=false;
 }//if

 msgShow(pass2,msg);
 
 if(flg) return true;
 else    return false;
}//checkPass

function checkName(){
 var n=$("input[id='name']");
 var flg=true;
 var msg="";
 if(! n.val()){
  msg="お名前が空欄です";
  flg=false;
 }//if
 msgShow(n,msg);
 
 if(flg) return true;
 else    return false;
}//checkName

function checkTel(){
 var n=$("input[id='tel']");
 var flg=true;
 var msg="";

 if(n.val() && ! n.val().match(/^[0-9]{2,3}[\-]?[0-9]{3,4}[\-]?[0-9]{3,4}$/)){
  msg="電話番号を確認してください。";
  flg=false;
 }//if
 else{
  msg="";
  flg=true;
 }

 msgShow(n,msg);
 
 if(flg) return true;
 else    return false;

}//checkTel

function msgShow(elem,msg){
 var e=elem.parent().find("span");
 e.text(msg);
}//msgShow

function sendData(){
 var data={};
 var flg=true;
 var msg="この内容で登録しますか?";
 if(! checkPass()) flg=false;
 if(! checkName()) flg=false;
 if(! checkTel())  flg=false;
 if(! flg) return false;
 if(! confirm(msg)) return false;

 //メールアドレスをPOSTに追加
 var usermail=$("div#mail").text();
 var checkcode=$("div.md5").text();
 $("form").append("<input type='text' id='usermail' name='usermail' value='"+usermail+"'>");
 $("form").append("<input type='text' id='checkcode' name='checkcode' value='"+checkcode+"'>");
 return true;
}
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
     <h1>お客様情報登録</h1>
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
      <p> <?php echo $msg; ?> </p>
      <form action="./userresult.php" method="post">
       <dl class="login">
        <dt>メールアドレス:</dt>
        <dd><div id="mail"><?php echo $user["usermail"]; ?></div></dd>
        <dt><label for="password">パスワード:</label></dt>
        <dd><input id ="password" name="password" type="password" value=""></dd>
        <dt><label for="password2">パスワード確認:</label></dt>
        <dd><input id ="password2" name="password2" type="password" value=""><span></span></dd>
        <dt><label for="name">お名前:</label></dt>
        <dd><input id ="name" name="name" type="text" value="<?php echo $user["name"]; ?>"><span></span></dd>
        <dt><label for="tel">電話番号:</label></dt>
        <dd><input id ="tel" name="tel" type="text" value="<?php echo $user["tel"]; ?>"><span></span></dd>
        <dt><label for="address">ご住所:</label></dt>
        <dd><input id ="address" name="address" type="text" value="<?php echo $user["address"]; ?>"></dd>
        <dt>識別コード:</dt>
        <dd><div class="md5"><?php echo $user["checkcode"]; ?></div></dd>
        <dt></dt>
        <dd>
         <input name="touroku" type="submit" value="この内容で登録する">
        </dd>
       </dl>
      </form>


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
