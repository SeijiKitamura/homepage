<?php
//----------------------------------------------------------//
//  html.class.php 
//  html生成用クラス
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//

class html{
//----------------------------------------------------------//
// グループ用
//----------------------------------------------------------//
 public static function group(){
$html=<<<EOF
 <li>
  <a href='__LINK__' target='_blank'>
   __GROUP__
  </a>
 </li>
EOF;
  return $html;
 }// public static function group(){

//----------------------------------------------------------//
// グループ生成
//----------------------------------------------------------//
 public static function setgroup($data,$link,$group,$groupname){
  $html="";
  foreach($data as $rownum=>$rowdata){
   $n=$rowdata[$groupname]."(".$rowdata["cnt"].")";
   $base=self::group();
   $base=str_replace("__LINK__",$link.$rowdata[$group],$base);
   $base=str_replace("__GROUP__",$n,$base);
   $html.=$base;
  }//foreach
  $html="<ul class='group'>\n".$html."</ul>\n";
  return $html;
 }//public static function setgroup(){

//----------------------------------------------------------//
// 単品一覧用
//----------------------------------------------------------//
 private static function item(){
$html=<<<EOF
<div class='item'>
 <div class='imgdiv'>
  <a href='__LINK__' target="_blank">
   <img src='__IMGLINK__' alt='__SNAME__' title='__SNAME__'>
  </a>
 </div> 
 <div class='datadiv'>
  <h3 class='sname'>   
   <a href='__LINK__' target="_blank">
    __MAKER__ __SNAME__
   </a>
  </h3>

  <div class='tani' >__TANI__&nbsp;</div>
  <div class='price'>__PRICE__<span>__EN__</span></div>
  <div class='clr'></div>
  <div class='notice'>__NOTICE__&nbsp;</div>
  <div class='lastsale'>__LASTSALE__&nbsp;</div>
 </div>
</div>
EOF;

  return $html;
 }//public static function item(){

//----------------------------------------------------------//
// 単品一覧生成
//----------------------------------------------------------//
 public static function setitem($data){
  $html="";
  foreach ($data as $rownum=>$rowdata){
   $base=self::item();

   //画像がなければ非表示
   $img=IMGDIR.$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if

   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   $base=str_replace("__LASTSALE__",$rowdata["lastsale"],$base);
   $html.=$base;
  }//foreach
  
  $html.="<div class='clr'></div>\n";
  return $html;
 }//public static function setitem($data){

//----------------------------------------------------------//
// 単品用
//----------------------------------------------------------//
 private static function tanpin(){
$html=<<<EOF
<div class='tanpin'>
 <div class='imgdiv'>
  <img src='__IMGLINK__' alt='__SNAME__' title='__SNAME__'>
 </div> 
 <div class='datadiv'>
  <h3 class='sname'>__MAKER__ __SNAME__</h3>
  <div class='tani' >__TANI__&nbsp;</div>
  <div class='price'>__PRICE__<span>__EN__</span></div>
  <div class='clr'></div>
  <div class='notice'>__NOTICE__&nbsp;</div>
  <div class='jcode'>JAN:__JCODE__</div>
  <div class='lastsale'>__LASTSALE__&nbsp;</div>
 </div>
</div>
<div class='clr'></div>
EOF;

  return $html;
 }//private static function tanpin(){
//----------------------------------------------------------//
// 単品一覧生成
//----------------------------------------------------------//
 public static function settanpin($data){
  $html="";
  foreach ($data as $rownum=>$rowdata){
   $base=self::tanpin();
 
   //画像がなければ非表示
   $img=IMGDIR.$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
 
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   $base=str_replace("__JCODE__",$rowdata["jcode"],$base);
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   $base=str_replace("__LASTSALE__",$rowdata["lastsale"],$base);
   $html.=$base;
  }//foreach
  return $html;

 }//public static function settanpin($data){

}//class html{
?>
