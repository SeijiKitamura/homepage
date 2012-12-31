<?php
require_once("./php/html.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader2($base);
 $page->getGroup(4);
 $grp=$page->items;

}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>

   <div id="main">
    <h1>平成25年度　新卒募集について</h1>
    平成25年度新卒募集は予定人数に達したため終了しました。
   </div>
<!-- --------------------  main      end   --------------------------  -->

<!-- *********************  leftside start   ***************** -->
  <div id="leftside">
<?php
 $html="";
 foreach($grp as $rownum=>$rowdata){
  $html.="<li>";
  $html.="<a href='".$rowdata["url"]."'>";
  $html.=$rowdata["title"];
  $html.="</a>";
  $html.="</li>\n";
 }//foreach
 $html="<ul class='group'>".$html."</ul>";
 echo $html;
?>
   </div>
<!-- *********************  leftside end     ***************** -->


<!-- --------------------  footer start  ---------------------------  -->
<?php
$page->setFooter($base);
?>
