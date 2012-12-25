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

if(! $saleyear) $saleyear=date("Y");
if(! $salemonth) $salemonth=date("m");
//カレンダーゲット
 $db=new CL();
 $db->saleday=$saleyear."-".$salemonth."-1";

 //当日のカレンダー情報ゲット
 $db->saleday=date("Y-m-d");
 $db->getCalendar();
 $cal=$db->items["data"];

 //当月以降のカレンダーリストゲット
 $db->saleday=date("Y-m-d");
 $db->getMonthList();
 $monthlist=$db->items["data"];
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>

<!--=======================leftside start==============================-->
   <div id="leftside">
<?php
if($monthlist){
 $html="";
 $html ="<ul class='group'>";
 foreach($monthlist as $rownum=>$rowdata){
  $html.="<li>";
  if($rowdata["nen"]!=$saleyear || $rowdata["tuki"]!=$salemonth){
   $html.="<a href='?saleyear=".$rowdata["nen"]."&salemonth=".$rowdata["tuki"]."'>";
  }//if
  
  $html.=$rowdata["nen"]."年".$rowdata["tuki"]."月(".$rowdata["cnt"].")";

  if($rowdata["nen"]!=$saleyear || $rowdata["tuki"]!=$salemonth){
   $html.="</a>";
  }//if
  $html.="</li>\n";
 }//foreach
 $html.="</ul>";
 $html.="<div class='clr'></div>\n";
 echo $html;
}
?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================main      start=============================-->
   <div id="main">
<?php
//----------------------------------------------------------------//
// カレンダー情報
//----------------------------------------------------------------//
$fname=SITEDIR.HOME.$saleyear.$salemonth.".html";
$html=file_get_contents($fname);
//if($cal){
// echo "<h4>本日のカレンダー情報:\n";
// $j=0;
// $item=null;
// $html=$cal[0]["sname"]." ".$cal[0]["price"]."</h4>\n";
// echo $html;
//}//if
//$html=html::setcalendar($calitem);
echo $html;
?>
   </div>
<!--=======================main      end  =============================-->

<!--=======================footer    start=============================-->
<?php
$page->setFooter($base);
?>
