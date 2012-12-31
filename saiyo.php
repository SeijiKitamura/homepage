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
    <h1>採用方針</h1>
    <h2>仕事は楽しく</h2>
    <p>
     「仕事は楽しくやろう」というのが当社の合言葉です。<br />
     これが簡単なようで実はすごく難しいんです。<br />
     初めは戸惑う仕事内容も慣れてくると単調に感じてしまいます。<br />

     そんなときに必要になってくるのが向上心です。<br />
     昨日よりも今日。<br />
     今日よりも明日。<br />
     常に目標をもつことが「仕事を楽しくやる」大事な条件となってきます。<br />

     採用もここに重点をおいています。<br />
     設定した目標にむかって努力し、達成できたときの喜びに共感できる方を<br />
     当社は求めています。<br />
    </p>

    <h2>基礎となる考え方</h2>
    <p>
     「みんな仲良く」<br />
     「まじめにやりな」<br />
      創業より言い伝えられてきたこの言葉に当社の考え方全てが凝縮されています。<br />

     <h2>「みんな仲良く」とは？</h2>

      みんな仲良くとは慣れ合いになることではありません。<br />
      相手を人として尊重し<br />
      でも自分の意見も述べる<br />
      仕事という共通した目標にむかって、表面上のなかよしではなく本当のなかよしになろうという意味
      です。<br />

      <h2>「まじめにやりな」とは？</h2>
      これはこの言葉どおりです。<br />
      決めたらすぐに実行する<br />
      あきらめずに物事をやり通す<br />
      自分自身ではなかなか思い通りにならないことも皆で助けあってひとつのことをやり遂げる。<br />
      たとえ結果がでなくてもあきらめない。<br />

      これが当社の基本となる考え方です。<br />

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
