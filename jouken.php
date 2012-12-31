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
    <h1>応募条件・スケジュール</h1>
    <h2>応募条件</h2>
     <dl class="oubo">
      <dt>応募資格:</dt>
      <dd>平成23年度高等学校卒業が見込まれる方</dd>
      <dt class="rowend"></dt>
      <dd class="rowend">東京都大田区近郊にお住まいの方</dd>
     </dl>

    <div class="clr"></div>
    <h2>入社までのスケジュール</h2>
    <dl class="oubo">
     <dt><h4>1. 職場見学</h4></dt>
     <dd> 随時受付中。ご希望の方は当社採用担当まで連絡ください。</dd>

     <dt><h4>2. 面接・筆記試験</h4></dt>
     <dd>志望動機等を伺います。その後、筆記試験を行います。</dd>

     <dt><h4>3. 採用通知</h4></dt>
     <dd>面接後、1週間程度でご自宅に郵送いたします。</dd>

     <dt><h4>4. 入社前準備説明会</h4></dt>
     <dd> 入社式にむけて準備しておくことなどを説明いたします。</dd>

     <dt class="rowend"><h4>5. 入社式</h4></dt>
     <dd class="rowend">当社にてささやかな入社式を行います。</dd>
    </dl>
 
   </div>
<!-- --------------------  main      end   --------------------------  -->

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


<!-- --------------------  footer start  ---------------------------  -->
<?php
$page->setFooter($base);
?>
