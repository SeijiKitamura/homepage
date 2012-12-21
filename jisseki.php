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

<!-- *********************  leftside start   ***************** -->
  <div id="leftside">
<?php
 $html="";
 foreach($grp as $rownum=>$rowdata){
  $html.="<li>";
  if($rowdata["pagename"]!=$base){
   $html.="<a href='".$rowdata["url"]."'>";
  }
  $html.=$rowdata["title"];
  if($rowdata["pagename"]!=$base){
   $html.="</a>";
  }
  $html.="</li>\n";
 }//foreach
 $html="<ul class='group'>".$html."</ul>";
 echo $html;
?>
   </div>
<!-- *********************  leftside end     ***************** -->

   <div id="main">
    <h1>採用実績と在籍者数</h1>
    <h2>採用実績</h2>
    東京実業高等学校<br />
    大森学園高等学校<br />
    都立蒲田高等学校<br />
    都立大森高等学校<br />
    都立六郷工科高等学校<br />
    <h2>採用者数と在籍者数</h2>
    <ul>
     <li>
      <div class="nen">年</div>
      <div class="saiyo">採用者数</div>
      <div class="zaiseki">在籍者数</div>
     </li>
     <div class="clr"></div>
     <li>
      <div class="nen">2009年</div>
      <div class="saiyo">1人</div>
      <div class="zaiseki">0人</div>
     </li>
     <div class="clr"></div>
     <li>
      <div class="nen">2010年</div>
      <div class="saiyo">2人</div>
      <div class="zaiseki">1人</div>
     </li>
     <div class="clr"></div>
     <li>
      <div class="nen">2011年</div>
      <div class="saiyo">3人</div>
      <div class="zaiseki">2人</div>
     </li>
     <div class="clr"></div>
     <li>
      <div class="nen rowend">2012年</div>
      <div class="saiyo rowend">4人</div>
      <div class="zaiseki rowend">2人</div>
     </li>
     <div class="clr"></div>
    </ul>
 
   </div>
<!-- --------------------  main      end   --------------------------  -->

<!-- --------------------  footer start  ---------------------------  -->
<?php
$page->setFooter($base);
?>
