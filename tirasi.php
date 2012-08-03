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
    </div>
    <!-- search -->
   </div>
   <!-- navi -->
<?php
require_once("./php/tirasi.class.php");
try{
//------------------------------------------------------------//
// データゲット
//------------------------------------------------------------//
 $db=new TIRASI();

 //引数セット
 $tirasi_id=$_GET["tirasi_id"];
 $hiduke=$_GET["hiduke"];

 //タイトル一覧(今日以降のもの)
 $db->getTitleList(date("Y-m-d"));
 $data["titles"]=$db->items;
 
 //販売日覧
 $db->getDayList($tirasi_id);
 $data["days"]=$db->items;

 //商品一覧(引数が有効ならそのチラシアイテムを表示)
 $db->getItemList($tirasi_id,$hiduke);
 $data["items"]=$db->items;

 //タイトル確定
 foreach($data["titles"]["data"] as $key => $val){
  if($val["tirasi_id"]==$data["items"]["data"][0]["tirasi_id"]){
   $data["title"]["data"][]=$data["titles"]["data"][$key];
   $data["title"]["status"]=true;
   break;
  }//if
 }//for

}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}//catch
?>

   <!-- leftside -->
   <div id="leftside">
    <ul>
<?PHP
try{
 //表示終了日が今より先のチラシタイトルを表示
 foreach($data["titles"]["data"] as $key=>$val){
  //リセット
  $title="";

  //表示開始日が今より先なら「仮」をセット
  if(strtotime($val["view_start"])>time()) $title="[仮] ";

  //日付表示変換
  $title.=date("n月j日",strtotime($val["hiduke"]))."<br /> ";
  $title.=$val["title"];

  echo "<li>"; 
  $url="tirasi.php?tirasi_id=".$val["tirasi_id"];
  echo "<a href='".$url."'>"; //ここにリンクを作成
  echo $title;
  echo "</a></li>\n";
 }//foreach
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}

?>
    </ul>
   </div>
   <!-- leftside -->

   <!-- rightside -->
   <div id="rightside">

    <!-- todayevent -->
    <a href="calendar.php" target="_blank">
    <div class="event">
      <h4>本日のイベント</h4>
      カレンダーの内容を表示。<br/>
      クリックしたら
      カレンダーページへ移動
    </div>
    </a>
    <!-- todayevent -->

    <!-- mailbox -->
    <div class="event">
     <h4>メール情報</h4>
     メールの内容を表示。<br/>
     クリックしたら
     メール一覧ページへ移動

    </div>
    <!-- mailbox -->

    <!-- twitter -->
    <div class="event">
     <h4>ツイッター</h4>
     ツイッターウィジットを表示
    </div>
    <!-- twitter -->

    <!-- koukoku -->
    <div class="event">
     <h4>チラシ広告</h4>
     広告イメージを表示。<br />
     クリックしたら広告ページへ移動

    </div>
    <!-- koukoku -->

   </div>
   <!-- rightside -->

   <!-- main -->
   <div id="main">
   
    <!-- tirasiitem -->
    <div id="tirasiitem">
<?php
//エラーがあれば処理終了
if($err){
 echo "<pre>";
 print_r($err);
 echo "</pre>";
 return false;
}

//販売日リスト作成
$li="";
foreach($data["days"]["data"] as $key => $val){
 $li.="<li>";
 $url ="tirasi.php?tirasi_id=".$data["title"]["data"][0]["tirasi_id"];
 $url.="&hiduke=".$val["hiduke"];
 $li.="<a href='".$url."'>"; //同一ページ該当日付へリンク
 $li.=date("n月j日 ",strtotime($val["hiduke"]));
 $li.="(".$val["items"].")";
 $li.="</a>";
 $li.="</li>\n";
}
//$div.="<div class='clr'></div>";
echo "<ul class='dayslist'>\n".$li."</ul>\n";
echo "<div class='clr'></div>";

//商品表示
$html="";
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
 $html.="<a>\n"; //単品画面へリンク
 $html.="<div class='imgdiv'><img src='./img/".$col["jcode"].".jpg' alt='".$col["sname"]."'></div>\n";
 $html.="<div class='makerdiv'>".$col["maker"]."</div>\n";
 $html.="<div class='snamediv'>".$col["sname"]."</div>\n";
 $html.="<div class='tanidiv'>".$col["tani"]."</div>\n";
 $html.="<div class='baikadiv'><span>".$col["baika"]."</span>円</div>\n";
 $html.="<div class='jcodediv'>JAN:".$col["jcode"]."</div>\n";
 $html.="</a>\n";

 //現在の値をセット
 $endday=$col["endday"];
 $subtitle=$col["subtitle"];
}//foreach

$html.="<div class='clr'></div>";

echo $html;
echo "<pre>";
print_r($data);
echo "</pre>";
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
