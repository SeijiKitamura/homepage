<?php
require_once("./php/maillist.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader($base);

 $jcode=$_GET["jcode"];

 //引数チェック
 if($jcode && ! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください");
 }//if

 //メール商品ゲット
 $db=new ML();
 $db->saleday="2012/11/02";
 $db->getMailItem();
 $mailitem=$db->items["data"];
 if($jcode){
  $db->getTanpin($jcode);
  $item=$db->items["data"];
 }//if
 $db->getDayList();
 $daylist=$db->items["data"];

 $db->set2osusume();
 $db->getMailItem();
 $osusume=$db->items["data"];
}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>
<!--=======================leftside start==============================-->
   <div id="leftside">
<?php
$html="";
$html.="<ul class='group'>";
foreach ($daylist as $rownum =>$rowdata){
 $html.="<li>";
 if(strtotime($rowdata["saleday"])!=strtotime($db->saleday)){
  $html.="<a href='?".$db->saleday."'>";
  $html.=date("m月d日",strtotime($rowdata["saleday"]))."(".$rowdata["cnt"].")";
  $html.="</a>";
 }//if
 else{
  $html.=date("m月d日",strtotime($rowdata["saleday"]))."(".$rowdata["cnt"].")";
 }
 $html.="</li>";
}
$html.="</ul>";
$html.="<div class='clr'></div>";
echo $html;
?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================main      start=============================-->
   <div id="main" style="width:780px;">
<?php
//----------------------------------------------------------------//
// 単品表示
//----------------------------------------------------------------//
//----------------------------------------------------------------//
// メール表示
//----------------------------------------------------------------//
if($mailitem){
 echo "<h3> 本日のメール商品</h3>\n";
 if($item){
  $html=html::settanpin($item);
  $html=str_replace("__LASTSALE__","限り",$html);
  echo $html;
 }
 $html=html::setitem($mailitem);
 $html=str_replace("__LASTSALE__","限り",$html);
 echo $html;
}//if

if($osusume){
 echo "<h3> 本日のおすすめ商品</h3>\n";
 if($item){
  $html=html::settanpin($item);
  $html=str_replace("__LASTSALE__","限り",$html);
  echo $html;
 }
 $html=str_replace("__LASTSALE__","限り",$html);
 $html=html::setitem($osusume);
 echo $html;

}//if
if(! $mailitem && ! $osusume){
 echo date("H時i分")."現在、本日のメールはまだ配信されておりません";
}//if
else{
 echo "<pre>";
 echo $GLOBALS["MENSEKI"];
 echo "</pre>";
}
?>
   </div>
<!--=======================main      end  =============================-->

<!--=======================footer    start=============================-->
<?php
$page->setFooter($base);
?>
