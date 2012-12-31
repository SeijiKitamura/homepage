<?php
require_once("./php/html.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader2($base);
 $page->getGroup(3);
 $grp=$page->items;


}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>

   <div id="main">
    <dl class="about">
     <dt>会社名</dt>
     <dd>株式会社　スーパーキタムラ</dd>
     <dt>所在地</dt>
     <dd>
      〒143-0025 東京都大田区南馬込4-21-10
     </dd>
     <dt>電話・FAX</dt>
     <dd>
      Tel:03-3771-8284(代表) Fax:03-3773-0605
     </dd>
     <dt>代表取締役</dt>
     <dd>北村　安祥(やすよし)</dd>
     <dt>設立</dt>
     <dd>1981年10月</dd>
     <dt>資本金</dt>
     <dd>99,000,000円</dd>
     <dt>従業員数</dt>
     <dd>フルタイム 40人 アルバイト 20人</dd>
     <dt class="rowend">事業内容</dt>
     <dd class="rowend">
      食品スーパーマーケット
     </dd>
    </dl>
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
