<?php
require_once("./php/tirasi.class.php");
try{
//------------------------------------------------------------//
// データゲット
// $data["titles"]["data"]    チラシ投函日日程一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["days"]  ["data"]    単一チラシ日程
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["items"] ["data"]    指定日の商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//      ["title"] ["data"]    指定チラシのタイトル、日程
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["linlist"]["data"]    指定日のラインリスト、アイテム数
//                ["status"]  true false
//                ["local"]   日本語列名
//------------------------------------------------------------//
 $db=new TIRASI();

 //引数セット
 $tirasi_id=$_GET["tirasi_id"];
 $hiduke=$_GET["hiduke"];
 $lincode=$_GET["lincode"];

 //引数チェック
 if(! $tirasi_id ||! is_numeric($tirasi_id)){
  throw new exception("チラシ番号は数字で入力してください");
 }

 if(! $hiduke ||! CHKDATE($hiduke)){
  throw new exception("日付が不正です");
 }

 //タイトル一覧    (共通)
 $db->getTitleList(date("Y-m-d"));
 $data["titles"]=$db->items;
 
 //販売日覧        (共通)
 $db->getDayList($tirasi_id);
 $data["days"]=$db->items;

 //指定日の商品一覧  (共通)
 $db->getItemList($tirasi_id,$hiduke,$lincode);
 $data["items"]=$db->items;
 
 //チラシ全体の商品一覧(使い道あるのか?)
 $db->getItemList($tirasi_id,"all");
 $data["allitems"]=$db->items;

 //タイトル確定      (共通)
 foreach($data["titles"]["data"] as $key => $val){
  if($val["tirasi_id"]==$data["items"]["data"][0]["tirasi_id"]){
   $data["title"]["data"][]=$data["titles"]["data"][$key];
   $data["title"]["status"]=true;
   break;
  }//if
 }//for

 //チラシ番号確定 (tirasi.php 固有)
 if(! $tirasi_id){
  $tirasi_id=$data["title"]["data"][0]["tirasi_id"];
 }

 //日付確定       (tirasi.php 固有)
 if(! $hiduke){
  $hiduke=$data["items"]["data"][0]["startday"];
 }

 //ラインリスト作成 (共通)
 $db->getLinList($tirasi_id,$hiduke);
 $data["linlist"]=$db->items;

 //翌日の同一linのチラシ商品(表示している単品を除く) (共通)
 $nextday=date("Y-m-d",strtotime("+1 days",strtotime($hiduke)));
 $db->getItemList($tirasi_id,$nextday,$lincode);
 $d=$db->items["data"];
 foreach($d as $key=>$val){
  $flg=1;
  foreach($data["items"]["data"] as $key1=>$val1){
   if($val["jcode"]==$val1["jcode"] || $val["jcode"]==$data["item"]["data"][0]["jcode"]){
    $flg=0;
    break;
   }//if
  }//foreach
  if($flg) $data["nextitems"]["data"][]=$val;
 }//foreach

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
<?php
//販売日リスト作成
$li="";
foreach($data["days"]["data"] as $key => $val){
 $li.="<li>";
 $url ="tirasi.php?tirasi_id=".$data["title"]["data"][0]["tirasi_id"];
 $url.="&hiduke=".$val["hiduke"]."&lincode=".$lincode;
 if($hiduke!=$val["hiduke"]){
  $li.="<a href='".$url."'>"; //同一ページ該当日付へリンク
 }
 $li.=date("n月j日 ",strtotime($val["hiduke"]));
 $li.="(".$val["items"].")";
 if($hiduke!=$val["hiduke"]){
  $li.="</a>";
 }
 $li.="</li>\n";
}
//$div.="<div class='clr'></div>";
echo "<ul class='dayslist'>\n".$li."</ul>\n";
echo "<div class='clr'></div>";
?>
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside">
    <ul>
<?PHP
try{
 $url ="./tirasi.php?tirasi_id=".$tirasi_id."&hiduke=".$hiduke;
 $li ="";
 $li ="<li>";
 if($lincode) $li.="<a href='".$url."'>";
 $li.="すべての商品";
 if($lincode) $li.="</a>";
 $li.="</li>\n";
 foreach($data["linlist"]["data"] as $key =>$col){
  $url ="./tirasi.php?tirasi_id=".$tirasi_id."&hiduke=".$hiduke;
  $url.="&lincode=".$col["lincode"];
  $li.="<li>";
  if($col["lincode"]!=$lincode) $li.="<a href='".$url."'>";
  $li.=$col["linname"]."(".$col["cnt"].")";
  if($col["lincode"]!=$lincode) $li.="</a>";
  $li.="</li>\n";
 }//foreach
 echo $li;
}//try
catch(Exception $e){
 $err[]=$e->getMessage();
}//catch
?>
    </ul>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">
    <!-- nextday -->
    <div class="tirasiitem">
<?php
//商品表示
$html="";
$endday=null;
foreach($data["nextitems"]["data"] as $key=>$col){
 //終了日が変われば期間を表示
 if($col["endday"]!==$endday){
  if($col["startday"]===$col["endday"]){
   $msg=date("n月j日",strtotime($col["endday"]))."限り";
  }
  else{
  $msg =date("n月j日",strtotime($col["startday"]))."から";
  $msg.=date("n月j日",strtotime($col["endday"]))."まで";
  }
  $html.="<div class='clr'></div>";
  $html.="<h3>".$msg."</h3>\n";
 }//if
  
 //subtitleが変更すればタイトル表示
 if($col["subtitle"] && $col["subtitle"]!==$subtitle){
  $html.="<div class='clr'></div>";
  $html.="<h4>".$col["subtitle"]."</h4>\n";
 }//if
 
 //商品表示(目玉なら特別表示)
 $url ="tirasiitem.php?tirasi_id=".$col["tirasi_id"];
 $url.="&hiduke=".$col["startday"];
 $url.="&lincode=".$col["lincode"];
 $url.="&jcode=".$col["jcode"];
 $html.="<a href='".$url."'>\n"; //単品画面へリンク
 $html.="<div class='imgdiv'><img src='./img/".$col["jcode"].".jpg' alt='".$col["sname"]."'></div>\n";
 $html.="<div class='makerdiv'>".$col["maker"]."</div>\n";
 $html.="<div class='snamediv'>".$col["sname"]."</div>\n";
 $html.="<div class='tanidiv'>".$col["tani"]."</div>\n";
 $html.="<div class='baikadiv'><span>".$col["baika"]."</span>円</div>\n";
 //$html.="<div class='tanidiv'>".$col["notice"]."</div>\n";
 //$html.="<div class='jcodediv'>JAN:".$col["jcode"]."</div>\n";
 $html.="<div class='makerdiv'>".$msg.$col["notice"]."</div>\n";
 $html.="</a>\n";

 //現在の値をセット
 $endday=$col["endday"];
 $subtitle=$col["subtitle"];
}//foreach

$html.="<div class='clr'></div>";
echo $html;

?>
    </div>
    <!-- nextday -->
   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
   
    <!-- tirasiitem -->
    <div class="tirasiitem">
<?php
//エラーがあれば処理終了
if($err){
 echo "<pre>";
 print_r($err);
 echo "</pre>";
 return false;
}
//商品表示
$html="";
$endday=null;
foreach($data["items"]["data"] as $key=>$col){
 //終了日が変われば期間を表示
 if($col["endday"]!==$endday){
  if($col["startday"]===$col["endday"]){
   $msg=date("n月j日",strtotime($col["endday"]))."限り";
  }
  else{
  $msg =date("n月j日",strtotime($col["startday"]))."から";
  $msg.=date("n月j日",strtotime($col["endday"]))."まで";
  }
  $html.="<div class='clr'></div>";
  $html.="<h3>".$msg."</h3>\n";
 }//if
  
 //subtitleが変更すればタイトル表示
 if($col["subtitle"] && $col["subtitle"]!==$subtitle){
  $html.="<div class='clr'></div>";
  $html.="<h4>".$col["subtitle"]."</h4>\n";
 }//if
 
 //商品表示(目玉なら特別表示)
 $url ="tirasiitem.php?tirasi_id=".$col["tirasi_id"];
 $url.="&hiduke=".$col["startday"];
 $url.="&lincode=".$col["lincode"];
 $url.="&jcode=".$col["jcode"];
 $html.="<a href='".$url."'>\n"; //単品画面へリンク
 $html.="<div class='imgdiv'><img src='./img/".$col["jcode"].".jpg' alt='".$col["sname"]."'></div>\n";
 $html.="<div class='makerdiv'>".$col["maker"]."</div>\n";
 $html.="<div class='snamediv'>".$col["sname"]."</div>\n";
 $html.="<div class='tanidiv'>".$col["tani"]."</div>\n";
 $html.="<div class='baikadiv'><span>".$col["baika"]."</span>円</div>\n";
 $html.="<div class='tanidiv'>".$col["notice"]."</div>\n";
 //$html.="<div class='jcodediv'>JAN:".$col["jcode"]."</div>\n";
 $html.="</a>\n";

 //現在の値をセット
 $endday=$col["endday"];
 $subtitle=$col["subtitle"];
}//foreach

$html.="<div class='clr'></div>";

echo $html;
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
