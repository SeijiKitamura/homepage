<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
require_once("./php/maillist.class.php");
require_once("./php/html.class.php");
try{
 $lincode=$_GET["lincode"];
 $clscode=$_GET["clscode"];
 $jcode=$_GET["jcode"];
 $page=$_GET["page"];

 //引数チェック
 if($lincode && ! is_numeric($lincode)){
  throw new exception("部門番号は数字で入力してください");
 }//if

 if($clscode && ! is_numeric($clscode)){
  throw new exception("クラスは数字で入力してください");
 }//if

 if($jcode && ! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください");
 }//if
 
 if(! $page) $page=1;
 if($page && ! is_numeric($page)){
  throw new exception("ページは数字で入力してください");
 }//if

 //分類グループゲット
 $db=new JANMAS();
 $db->getLinList();
 $linlist=$db->items["data"];
 if($lincode){
  $db->getClsList($lincode);
  $clslist=$db->items["data"];

  $db->getLinItem($lincode);
  $linitem=$db->items["data"];
 }//if

 if($clscode){
  $db->getClsItem($clscode);
  $clsitem=$db->items["data"];
 }//if

 if($jcode){
  $db->getJanItem($jcode);
  $item=$db->items["data"];
 }

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
     <a href="index.html">
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
      <li><a href='index.php'>ホーム</li>
      <li> | </li>
      <li><a href='tirasi.php'>今週のチラシ</a></li>
      <li> | </li>
      <li><a href="calendar.php">カレンダー</a></li>
      <li> | </li>
      <li>商品のご案内</li>
      <li> | </li>
      <li>ご注文承り中</li>
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
$html="";
$html="<ul class='group'>\n";
if(! $clslist){
 foreach($linlist as $rownum=>$rowdata){
  $html.="<li>";
  $html.="<a href='?lincode=".$rowdata["lincode"]."'>";
  $html.=$rowdata["linname"]." "."(".$rowdata["cnt"].")";
  $html.="</a>";
  $html.="</li>\n";
 }//foreach
}//if
elseif($clslist){
 foreach($clslist as $rownum=>$rowdata){
  $html.="<li>";
  if($rowdata["clscode"]!=$clscode){
   $html.="<a href='?lincode=".$lincode."&clscode=".$rowdata["clscode"]."'>";
   $html.=$rowdata["clsname"]." "."(".$rowdata["cnt"].")";
   $html.="</a>";
  }
  else{
   $html.=$rowdata["clsname"]." "."(".$rowdata["cnt"].")";
  }
  $html.="</li>\n";
 }//foreach
}//elseif
$html.="</ul>\n";
echo $html;

?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================rightside start=============================-->
<!--=======================rightside end  =============================-->

<!--=======================main      start=============================-->
   <div id="main" style="width:780px;">
<?php
if($clsitem){
 $data=$clsitem;
 $url="?lincode=".$lincode."&clscode=".$clscode;
}
else if(! $clsitem){
 $data=$linitem;
 $url="?lincode=".$lincode;
}
$html ="";
$html ="<ul class='pagenavi'>";
$html.="<li><a href='item.php'>商品のご案内 > </a></li>";
if($clscode){
 $html.="<li><a href='item.php?lincode=".$data[0]["lincode"]."'>";
 $html.=$data[0]["linname"]." > ";
 $html.="</a></li>\n";
 $html.="<li> ".$data[0]["clsname"]." </li>\n";
}
elseif(! $clscode){
 $html.="<li> ";
 $html.=$data[0]["linname"];
 $html.="</li>\n";
}
$html.="</ul>";
$html.="<div class='clr'></div>\n";
echo $html;

//echo "<pre>";
//print_r($data);
//echo "</pre>";
$startpage=$page-NAVISTART; //開始ベージセット
if($startpage<1) $startpage=1;

$endpage=floor(count($data)/JANMASLIMIT);//最終ページセット
if(count($data) % JANMASLIMIT>0) $endpage++;

$navilength=NAVISPAN;//表示するページ数
if($endpage>$startpage+$navilength){
 $endpage=$startpage+$navilength;
}//if

//ナビゲーター生成
$navi="<ul class='itemnavi'>\n";
for($i=$startpage;$i<=$endpage;$i++){
 $navi.="<li>";
 if($i!=$page) $navi.="<a href='".$url."&page=".$i."'>".$i."</a>";
 else $navi.=$i;
 $navi.="</li>";
}//for
$navi.="</ul>\n";
$navi.="<div class='clr'></div>\n";
echo $navi;

//アイテム表示
$startitem=($page-1)*JANMASLIMIT;
$enditem=$startitem+JANMASLIMIT;
if($enditem>count($data)) $enditem=count($data);
for($i=$startitem;$i<$enditem;$i++){
 $itemdata[]=$data[$i];
}//for
$html=html::setitem($itemdata);
echo $html;
echo $navi;

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
