<?php
require_once("./php/janmas.class.php");
require_once("./php/calendar.class.php");
require_once("./php/tirasi.class.php");
require_once("./php/maillist.class.php");
require_once("./php/html.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader($base);

 //分類グループゲット
 $db=new JANMAS();
 $db->getLinList();
 $grp=$db->items["data"];

 //新商品データゲット
 $db->getNewItem();
 $newitem=$db->items["data"];
 
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

<!-- :-------------------  leftside start  --------------------------  -->
  <div id="leftside">
<?php
$html=html::setgroup($grp,"item.php?lincode=","lincode","linname");
//taniとnoticeを除外
echo $html;
?>
   </div>
<!-- :-------------------  leftside end    --------------------------  -->

<!-- --------------------  main    start   --------------------------  -->
   <div id="main" style="width:780px;">
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


//----------------------------------------------------------------//
// 広告の品表示
//----------------------------------------------------------------//
if($tirasi){
 echo "<h3><a href='tirasiitem.php'>広告の品</a></h3>";

 //5アイテムに絞る
 $item=null;
 $j=0;
 for($i=0;$i<count($tirasi);$i++){
  $j++;
  if($j>5) break;
  $item[]=$tirasi[$i];
 }
 $html=html::setitemTirasi($item);
 $html=preg_replace("/\?/","tirasiitem.php?",$html);
 echo $html;

}//if

//----------------------------------------------------------------//
// メール表示
//----------------------------------------------------------------//
if($mailitem){
 echo "<h3><a href='mailitem.php'>本日のメール商品</a></h3>\n";
 //5アイテムに絞る
 $item=null;
 $j=0;
 for($i=0;$i<count($mailitem);$i++){
  $j++;
  if($j>5) break;
  $item[]=$mailitem[$i];
 }
 $html=html::setitem($item);
 $html=preg_replace("/\?/","mailitem.php?",$html);
 echo $html;

}//if

//----------------------------------------------------------------//
// 新商品表示
//----------------------------------------------------------------//
if($newitem){
 echo "<h3><a href='item.php'>新商品のご案内</a></h3>\n";
 $j=0;
 $item=null;
 //10アイテムに絞る
 for($i=0;$i<count($newitem);$i++){
  $j++;
  if($j>10) break;
  $item[]=$newitem[$i];
 }//for
 $html=html::setitem($item);
 $html=preg_replace("/<div class='tani'>.*<\/div>/","",$html);
 $html=preg_replace("/<div class='notice'>.*<\/div>/","",$html);
 $html=preg_replace("/\?/","item.php?",$html);
 echo $html;
}//if

echo "<pre>";
echo $GLOBALS["MENSEKI"];
echo "</pre>";
?>
   </div>
<!-- --------------------  main      end   --------------------------  -->

<!-- --------------------  footer  start  ---------------------------  -->
<?php
$page->setFooter($base);
?>
