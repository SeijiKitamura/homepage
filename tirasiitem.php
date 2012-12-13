<?php
require_once("./php/tirasi.class.php");
require_once("./php/page.class.php");

try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader($base);

 $lincode=$_GET["lincode"];
 $clscode=$_GET["clscode"];
 $jcode=$_GET["jcode"];

 //引数チェック
 if($lincode &&! is_numeric($lincode)){
  throw new exception("ラインコードは数字で入力してください。");
 }//if

 if($clscode &&! is_numeric($clscode)){
  throw new exception("クラスコードは数字で入力してください。");
 }//if

 if($jcode &&! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください。");
 }//if
 
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

<!--=======================footer    start=============================-->
<?php
$page->setFooter($base);
?>
