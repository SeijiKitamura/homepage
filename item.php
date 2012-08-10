<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");

try{
//------------------------------------------------------------//
// データゲット
// $data
//      ["item"]  ["data"]    JANコード指定時の単品データ
//                ["status"]  true false
//                ["local"]   日本語列名
//   ["clsitems"] ["data"]    同じクラスの商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//   ["linitems"] ["data"]    同じラインの商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//["searchitems"] ["data"]    検索商品一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["clslist"]["data"]    クラス一覧
//                ["status"]  true false
//                ["local"]   日本語列名
//     ["linlist"]["data"]    分類一覧数
//                ["status"]  true false
//                ["local"]   日本語列名
//    ["calendar"]["data"]    カレンダー
//                ["status"]  true false
//                ["local"]   日本語列名
//------------------------------------------------------------//

 //引数セット
 $lincode=$_GET["lincode"];
 $clscode=$_GET["clscode"];
 $jcode=$_GET["jcode"];
 $datanum=$_GET["datanum"];
 $word=$_GET["word"];
 $hiduke=$_GET["hiduke"];

 //引数チェック
 if($lincode && ! is_numeric($lincode)){
  throw new exception("ラインコードは数字で入力してください");
 }
 if($clscode && ! is_numeric($clscode)){
  throw new exception("クラスコードは数字で入力してください");
 }
 if($jcode && ! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください");
 }
 if($datanum && ! is_numeric($datanum)){
  throw new exception("表示番号は数字で入力してください");
 }
 if($hiduke && !CHKDATE($hiduke)){
  throw new exception("日付が不正です");
 }
 if(! $hiduke) $hiduke=date("Y-m-d");

 //calendarをゲット
 $cal=new CL();
 $cal->getItem($hiduke);
 $data["calendar"]=$cal->item;

 //単品マスタ系データゲット
 $db=new JANMAS();

 $db->getLinMas();
 $data["linlist"]=$db->items;

 $db->getClsMas($lincode);
 $data["clslist"]=$db->items;

 $db->getJanMas($lincode,$clscode,0,$datanum);
 $data["linitems"]=$db->items;

 //クラス内アイテムゲット
 if($clscode){
  $db->getJanMas($lincode,$clscode,0,$datanum);
  $data["clsitems"]=$db->items;
 }

 //単品データゲット
 if($jcode){
  $db->getJanMas($lincode,$clscode,$jcode,0);
  $data["item"]=$db->items;
 }

 //検索データゲット
 if($word){
  $db->getJanMas(null,null,null,$datanum,$word);
  $data["searchitems"]=$db->items;
  $data["linlist"]=null;
  $data["clslist"]=null;
  $data["linitems"]=null;
  if($data["searchitems"]["data"]){
   $data["linitems"]=$db->items;
  }//if
 }

 //ナビ表示
 $ulcls="itemnavi";

 //現在位置把握
 $start=$data["linitems"]["data"][0]["datanum"];
 $page=floor($start/JANMASLIMIT);
 $pages=ceil($data["linitems"]["total"]/JANMASLIMIT);
 
 //ナビ表示位置調整
 $startpage=$page - NAVISTART ;
 if($startpage<0) $startpage=0;
 
 $url ="item.php?lincode=".$lincode."&clscode=".$clscode;
 $url.="&hiduke=".$hiduke."&datanum=";
 if($word){
  $url ="item.php?word=".$word."&datanum=";
 }
 
 $j=0;
 //リスト作成
 $li="<li>ページ:</li>";
 for($i=$startpage;$i<$pages;$i++){
  $seturl="";
  if($page!=$i) $seturl=$url.($i*JANMASLIMIT);//リンク先URL
  $p=$i+1;//表示ページ数
 
  if($j>NAVISPAN && $pages>$j){
   $li.="<li><a href='".$seturl."'>more！</a></li>\n";
   break;
  }
 
  $li.="<li>";
  if($seturl) $li.="<a href='".$seturl."'>";
  $li.=$p;
  if($seturl) $li.="</a>";
  $li.="</li>\n";
  $j++;
  //echo "ページ数:".$p."URL:".$seturl."<br />";
 }//for
 $ul="<ul class='".$ulcls."'>".$li."</ul>\n";
 //$ul.="<div class='clr'></div>\n";


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
  <title>商品のご案内:食品スーパーマーケット　</title>

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
     <h1>商品のご案内</h1>
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
      <li><a href="index.html">ホーム</a></li>
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
    <!-- timesale -->
     
   <div class="clr"></div>
   </div>
   <!-- header -->

   <!-- navi -->
   <div id="navi">
    <!-- allcate -->
    <div id="allcate">
      <h2>グループ一覧</h2>
    </div>
    <!-- allcate -->

    <!-- search -->
    <div id="search">
<?php
echo $ul;
?>
     検索:<input name='searchitem' type="text" value='<?php echo $word; ?>'>
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
   <!-- leftside -->
   <div id="leftside" style="margin:0px !important;">
<?PHP
$html=$db->getHtmlLinList($data["linlist"],$lincode,$hiduke);
echo $html;
?>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside" style="float:left !important;margin:0 2px !important;">
<?php
$html=$db->getHtmlClsList($data["clslist"],$lincode,$clscode,$hiduke);
echo $html;
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

    <!-- calendar -->
    <div class="calendaritem">
<?php
if($data["calendar"]["data"]){
 $cal=$data["calendar"]["data"];
 $nen=date("Y",strtotime($cal["hiduke"]));
 $tuki=date("m",strtotime($cal["hiduke"]));
 $url="calendar.php?nen=".$nen."&tuki=".$tuki;
 $html ="<a href='".$url."'>\n";
 $html.="カレンダー情報：";
 $html.=date("n月j日",strtotime($cal["hiduke"]))."限り";
 $html.=$cal["title"]."全品".$cal["rate"];
 $html.="</a>\n";
 echo "<h4>".$html."</h4>\n";
}
?>
    </div>
    <!-- calendar -->

    <!-- tirasiitem -->
    <div class="tirasiitem">
     <!-- tanpin -->
     <div id="tanpin">
<?php
//単品表示
if($data["item"]["data"]){
 $html=$db->getHtmlJanMas($data["item"],0,$hiduke);
 echo $html;
}
?>
     </div>
     <!-- tanpin -->


     <!-- janmas -->
     <div class='janmas'>
<?php
if($word){
 echo "<h3>検索結果</h3>\n";

 //ここにinputタグを配置して検索できるようにしたい

 if( $data["searchitems"]["data"]){
  $html=$db->getHtmlJanMas($data["searchitems"],$datanum,$hiduke);
  echo $html;
 }//if
 else{
  echo "検索ワード:".$word." 見つかりませんでした。";
 }
}//if

//アイテム一覧表示
if(! $word &&! $data["searchitems"]["data"]){
$html=$db->getHtmlJanMas($data["linitems"],$datanum,$hiduke);
echo $html;
}

echo $ul;
?>
      <div class='clr'></div>
     </div>
     <!-- janmas -->

    </div>
    <!-- tirasiitem -->
    <p>
    <h4>表示されている商品について：</h4>
    こちらに表示されている商品は品揃えを保証するものではございません。
    こちらに表示されている商品でも、メーカーによる終売、品切、取扱中止、
    等の理由により販売できない場合もございます。誠に恐れいりますが、
    何卒ご了承くださいませ。<br />
    <h4>表示されている価格について：</h4>
    こちらに表示されている価格は、前日までの販売実績を元に表示しております。
    表示されている価格と店頭での価格に差異があった場合、誠に
    恐れ入りますが店頭での価格にて販売させていただきます。<br/>
    </p>
   </div>
   <!-- main -->

   <!--div class="clr"></div-->
   <!-- footer -->
   <div id="footer">
    <h1>footer</h1>
<?php
if(DEBUG){
 echo "<pre>";
 print_r($data);
 echo "</pre>";
}
?>
   </div>
   <!-- footer -->

  </div>
  <!-- wrapper -->
 </body>
</html>
