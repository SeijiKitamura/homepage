<?php
require_once("./php/html.class.php");
require_once("./php/page.class.php");
try{
 //ヘッダーを表示
 $base=basename($_SERVER["PHP_SELF"]);
 $page=new PAGE();
 $page->setHeader2($base);


}//try
catch(Exception $e){
 $err[]="エラー:".$e->getMessage();
}
?>

   <div id="main">
    <h1> 営業時間・地図のお知らせ </h1>
    <dl class="eigyojikan">
     <dt>店休日:</dt>
     <dd>年中無休です。元旦から大晦日まで1日もお休みはありません。</dd>
     <dt>営業時間:</dt>
     <dd>朝9時30分から夜10時まで</dd>
     <dt>所在地:</dt>
     <dd>〒143-0025<br />
         東京都大田区南馬込4-21-10(とうきょうとおたくみなみまごめ）</dd>
     <dt class="rowend">最寄り駅:</dt>
     <dd class="rowend">都営浅草線　西馬込駅　南口下車　徒歩15分</dd>
    </dl>
    <div class="map">
     <img src="./img/map.gif" alt="スーパーキタムラ 地図 アクセス マップ">
    </div>
   </div>
<!-- --------------------  main      end   --------------------------  -->

<!-- *********************  leftside start   ***************** -->
  <div id="leftside">
<?php
?>
   </div>
<!-- *********************  leftside end     ***************** -->


<!-- --------------------  footer start  ---------------------------  -->
<?php
$page->setFooter($base);
?>
