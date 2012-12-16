<?php
require_once("./php/goyoyaku.class.php");
require_once("./php/page.class.php");

try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader($base);

 $grpcode=$_GET["grpcode"];
 $jcode=$_GET["jcode"];

 //引数チェック
 if($grpcode &&! is_numeric($grpcode)){
  throw new exception("グループコードは数字で入力してください。");
 }//if

 if($jcode &&! is_numeric($jcode)){
  throw new exception("JANコードは数字で入力してください。");
 }//if
 
 //ご予約商品ゲット
 $db=new GOYOYAKU();

 //グループリストをゲット
 $db->getGrpList();
 $grplist=$db->items["data"];

 //全商品リストをゲット
 $db->getItemList();
 $grpitem=$db->items["data"];

 //グループ指定ならグループ商品をゲット
 if($grpcode){
  $db->getGrpItem($grpcode);
  $grpitem=$db->items["data"];
 }//if

 //単品指定なら単品をゲット
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
foreach($grplist as $rownum=>$rowdata){
 $html.="<li>";
 if($grpcode!=$rowdata["grpcode"]){
  $html.="<a href='?grpcode=".$rowdata["grpcode"]."'>";
 }

 $html.=$rowdata["grpname"]." "."(".$rowdata["cnt"].")";

 if($grpcode!=$rowdata["grpcode"]){
  $html.="</a>";
 }
 $html.="</li>\n";
}//foreach
$html.="</ul>\n";
echo $html;

?>
   </div>
<!--=======================leftside end  ==============================-->

<!--=======================main      start=============================-->
   <div id="main">
<?php
//開始日、終了日を表示
$grpname=$grpitem[0]["grpname"];
$kaisi=date("Y年m月d日",strtotime($grpitem[0]["kaisi"]));
$owari=date("Y年m月d日",strtotime($grpitem[0]["owari"]));
if(! $grpcode){
 echo "<h2>全商品一覧</h2>";
 echo "<h3>".$kaisi."から".$owari."まで</h3>";
}//if
else{
 echo "<h2>".$grpname."商品一覧"."</h2>";
 echo "<h3>".$kaisi."から".$owari."まで</h3>";
}//else
//単品表示
if($item){
 $html=html::settanpin($item);
 echo $html;
}//if

//アイテム表示
if($jcode){
 $grpitem=html::outJan($grpitem,$jcode);
}
$html=html::setitemGoyoyaku($grpitem);
echo $html;
echo "<div class='goyoyaku_footer'>";
echo $GLOBALS["MENSEKI2"];
echo "</div>";
?>
   </div>
<!--=======================main      end  =============================-->

<!--=======================footer    start=============================-->
<?php
$page->setFooter($base);
?>
