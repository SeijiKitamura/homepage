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
    <dl class="enkaku">
     <dt>1958年</dt>
     <dd> 株式会社 北村商店設立。店舗面積9坪。 </dd>
     <dt>1965年6月</dt>
     <dd> たばこ・塩販売開始。</dd>
     <dt>1965年7月</dt>
     <dd>
      有限会社 兼菊北村商店を設立し、株式会社 北村商店から食料品部門を分離。資本金100万円。
     </dd>
     <dt>1971年6月</dt>
     <dd> お酒販売開始。</dd>
     <dt>1981年10月</dt>
     <dd> スーパーマーケットとして開店。この日から現在まで1日も休むことなく営業中。店舗面積120坪。</dd>
     <dt>1983年11月</dt>
     <dd> お米販売開始。 </dd>
     <dt>1986年2月</dt>
     <dd>
      株式会社 スーパーキタムラを設立し、有限会社 兼菊北村商店から食料品部門を分離。資本金1000万円。
     </dd>
     <dt>1993年3月</dt>
     <dd> 増築。店舗面積250坪。(現在の店舗面積に至る)</dd>
     <dt>1997年6月</dt>
     <dd> 中央店開店。</dd>
     <dt>2000年1月</dt>
     <dd> 中央店閉店。 </dd>
     <dt>2002年6月</dt>
     <dd> 売場改装。自家製パン工場、「シェノール」開始。 </dd>
     <dt>2003年</dt>
     <dd> 売場改装。対面販売方式の天ぷらフライコーナー開始。 </dd>
     <dt>2003年12月</dt>
     <dd> 株式会社スーパーキタムラの資本金を4000万円へ増資。 </dd>
     <dt>2004年10月</dt>
     <dd> 売場改装。精肉、鮮魚売場に冷蔵平ケースを導入し売場拡大。 </dd>
     <dt>2007年9月</dt>
     <dd> 株式会社スーパーキタムラの資本金を9900万円へ増資。 </dd>
     <dt>2010年8月</dt>
     <dd> 売場改装。精肉売場を青果売場横へ移動。 </dd>
     <dt>2010年9月</dt>
     <dd> 配達サービス開始。 </dd>
     <dt>2012年10月</dt>
     <dd>ホーム館閉店</dd>
   </div>
<!-- --------------------  main      end   --------------------------  -->

<!-- *********************  leftside start   ***************** -->
  <div id="leftside">
<?php
 $html="";
 foreach($grp as $rownum=>$rowdata){
  $html.="<li>";
  if($rowdata["url"]!=$base){
   $html.="<a href='".$rowdata["url"]."'>";
  }
  $html.=$rowdata["title"];
  if($rowdata["url"]!=$base){
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
