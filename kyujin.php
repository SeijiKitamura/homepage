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
    <h1>求人内容</h1>
    申し訳ございません。ただいま求人は行なっておりません。
    <dl class="kyujin">
     <dt>契約区分:</dt>
     <dd></dd>
     <dt>仕事内容:</dt>
     <dd></dd>
     <dt>時給:</dt>
     <dd></dd>
     <dt>勤務時間:</dt>
     <dd></dd>
     <dt>応募資格:</dt>
     <dd></dd>
     <dt>必要書類:</dt>
     <dd>履歴書（写真付き）</dd>
     <dt class="rowend">申込方法</dt>
     <dd class="rowend">まずは採用担当(03-3771-8284)までお電話ください。その後、履歴書ご持参の上面接を行います。</dd>
    </dl>

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
