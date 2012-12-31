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
    <h1>仕事内容</h1>
    <h2>生鮮・惣菜</h2>
    <p>
      青果・精肉・鮮魚・惣菜のいずれかの部門に配属されます。<br />
      最初は品だし、簡単な商品加工から始まります。<br />
    </p>
    <h2>レジ</h2>
    <p>
      キャッシャーとしてレジ部門に配属されます。<br />
      最初は、先輩方と一緒にレジ打ちを行います。<br />
    </p>
    <h2>入社後のステップ</h2>
    <h3>1-3年目　作業スキルアップ</h3>
    <p>
    ひととおりの作業が自分1人でこなせることを目標としています。<br />
    最初は簡単な仕事からはじまり、徐々にステップアップ。<br />
    </p>

    <h3>4-6年目  企画・販売スキルアップ</h3>
    <p>
     販売計画を継続して作成することを目標としています。<br />
     自分で問題点をつかみ、改善できるスキルを身につけます。<br />
     最初は狭い範囲の商品郡からはじまり、徐々に範囲を広げていきます。<br />
    </p>

    <h3>7-10年目 管理・運営スキルアップ</h3>
    <p>
     部門全体を管理できることを目標としています。<br />
     最初は1つの部門からはじまり、徐々に複数の部門を管理するようになります。<br />
    </p>
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
