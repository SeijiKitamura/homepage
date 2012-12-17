<?php
require_once("./php/calendar.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダー表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader($base);

 $saleyear =$_GET["saleyear"];
 $salemonth=$_GET["salemonth"];

//引数チェック
if($saleyear && ! is_numeric($saleyear)){
 throw new exception("年は数字で入力してください");
}

if($salemonth && ! is_numeric($salemonth)){
 throw new exception("月は数字で入力してください");
}
//カレンダーゲット
 $db=new CL();
 if($saleyear && $salemonth){
  $db->saleday=$saleyear."-".$salemonth."-1";
 }
 //$db->saleday="2012/11/21";
 $db->getCalendar();
 $cal=$db->items["data"];
 $db->getItemList();
 $calitem=$db->items["data"];
 //当月のカレンダー日数
 $db->getMonthCount();
 $monthcal[]=$db->items["data"];

 //翌月のカレンダー日数
 $db->saleday=date("Y-m-d",strtotime("1month",strtotime($db->saleday)));
 $db->getMonthCount();
 $monthcal[]=$db->items["data"];
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>

<!--=======================leftside start==============================-->
   <div id="leftside">
<?php
$html="";
$html ="<ul class='group'>";
$html.="<li>";
$html.=$monthcal[0]["nen"]."年".$monthcal[0]["tuki"]."月";
$html.="(".$monthcal[0]["cnt"].")";
$html.="</li>\n";
if($monthcal[1]["cnt"]>0){
 $html.="<li><a href='?saleyear=".$monthcal[1]["nen"]."&salemonth=".$monthcal[1]["tuki"]."'>\n";
 $html.=$monthcal[1]["nen"]."年".$monthcal[1]["tuki"]."月";
 $html.="(".$monthcal[1]["cnt"].")";
 $html.="</a></li>\n";
}
$html.="</ul>";
$html.="<div class='clr'></div>\n";
echo $html;
?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================main      start=============================-->
   <div id="main">
<?php
//----------------------------------------------------------------//
// カレンダー情報
//----------------------------------------------------------------//
if($cal){
 echo "<h4>本日のカレンダー情報:\n";
 $j=0;
 $item=null;
 $html=$cal[0]["sname"]." ".$cal[0]["price"]."</h4>\n";
 echo $html;
}//if
$html=html::setcalendar($calitem);
echo $html;
?>
   </div>
<!--=======================main      end  =============================-->

<!--=======================footer    start=============================-->
<?php
$page->setFooter($base);
?>
