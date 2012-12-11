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

 //引数チェック
 
 //チラシ商品ゲット
 $db=new TIRASI();
 $db->flg0="734";
 $db->saleday="2012/11/29";
 $db->getItemList();
 $tirasiitem=$db->items["data"];
 $db->getLinList();
 $linlist=$db->items["data"];

 if($lincode){
  $db->getLinItem($lincode);
  $linitem=$db->items["data"];

  $db->getClsList($lincode);
  $clslist=$db->items["data"];
 }//if
 if($clscode){
  $db->getClsItem($clscode);
  $clsitem=$db->items["data"];
 }//if

 if($jcode){
  $db->getJanItem($jcode);
  $item=$db->items["data"];
 }//if
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
<?php
$base=basename($_SERVER["PHP_SELF"]);
$html=html::setpagelink($GLOBALS["PAGELINK1"],$base);
echo $html;
?>
    </div>
<!--=======================mininavi end  ==============================-->

<!--=======================timesale start==============================-->
    <div class="timesale">
<?php
$base=basename($_SERVER["PHP_SELF"]);
$html=html::setpagelink($GLOBALS["PAGELINK2"],$base);
echo $html;
?>
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
//ナビゲーター表示
$html="";
$html.="<ul class='pagenavi'>\n";
$html.="<li><a href='tirasiitem.php'>今週のチラシ</a> > </li>\n";
if($clscode){
 $html.="<li><a href='tirasiitem.php?lincode=".$lincode."'>";
 $html.=$clsitem[0]["linname"];
 $html.="</a> > </li>\n";
 $html.="<li>";
 $html.=$clsitem[0]["clsname"];
 $html.="</li>\n";
}//if
elseif( ! $clscode){
 $html.="<li>";
 $html.=$linitem[0]["linname"];
 $html.="</li>\n";
}
$html.="</ul>\n";
$html.="<div class='clr'></div>\n";
echo $html;

//単品表示
if($item){
 $html=html::settanpin($item);
 echo $html;
}//if
//アイテム表示
if($linitem && $clsitem){
 if($jcode){
  $clsitem=html::outJan($clsitem,$jcode);
 }
 $html=html::setitemTirasi($clsitem);
}
else if($linitem && ! $clsitem){
 if($jcode){
  $linitem=html::outJan($linitem,$jcode);
 }
 $html=html::setitemTirasi($linitem);
}
else{
 if($jcode){
  $tirasiitem=html::outJan($tirasiitem,$jcode);
 }
 $html=html::setitemTirasi($tirasiitem);
}
echo $html;
echo "<pre>";
echo $GLOBALS["MENSEKI"];
echo "</pre>";
?>
   </div>
<!--=======================main      end  =============================-->
   <div class="clr"></div>
<!--=======================footer    start=============================-->
   <div id="footer">
<?php
$base=basename($_SERVER["PHP_SELF"]);
echo html::setfooter($base);
?>
   </div>
<!--=======================footer    end  =============================-->

  </div>
<!--=======================wrapper end =================================-->
 </body>
</html>
