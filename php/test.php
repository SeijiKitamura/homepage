<!--
<html>
<head>
 <meta charset="utf-8">
 <meta http-equiv="Content-Style-Type" content="text/css">
 <link rel="stylesheet" href="../css/test.css" /> 
</head>
<body>
-->
<?php
require_once("tirasi.class.php");
require_once("calendar.class.php");
require_once("maillist.class.php");
require_once("janmas.class.php");
require_once("html.class.php");
require_once("page.class.php");

try{
 echo "success1";
 $db=new PAGE();
 echo "</pre>";
 $db->getPage("sinsotu.html");
 $html=html::sethead($db->items[0]);
 echo $html;
 echo "success2";
 return;
 $db=new JANMAS();
 $db->getNewItem();
 echo $db->html;
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";
 echo "success2";
 return;
 $html=html::settanpin($db->items["data"]);
 echo $html;
 return;
 $html=html::setitem($db->items["data"]);
 echo $html;
 $db=new CL();
 $db->saleday="2012/11/16";
 $db->getItemList();
 $html= html::setcalendar($db->items["data"]);
 echo $html;
 echo "<pre>";
 print_r($db->items)."\n";
 echo "</pre>";
return;


 $db=new TIRASI();
 $db->flg0=734;
 $db->saleday="2012/11/29";
 $db->getItemList();
 echo html::setitemTirasi($db->items["data"]);
 return;


  //インスタンス
 $db->getLinList();
 $html=html::setgroup($db->items["data"],"#","lincode","linname");
 echo $html;

 $db->getClsList(1);
 $html=html::setgroup($db->items["data"],"#","clscode","clsname");
 echo $html;


echo "<pre>";
 print_r($db->items);
 return;
 $db->getJanItem(4979754557176);
 $db->getClsItem(10108);
 print_r($db->items);

 $db->getLinItem(1);
 print_r($db->items);

 $db->getLinList();
 print_r($db->items);

 $db->getClsList(1);
 print_r($db->items);

 $db->getItemList();
 print_r($db->items);

 echo "</pre>";
 return;
 $test=" <img src='' >";
 $pattern="/<img.*/";
 echo preg_replace($pattern,"",$test);


// foreach($db->items["data"] as $rownum =>$rowdata){
//  echo $rowdata["price"];
//  $pattern="/[Pp]?[0-9]*(半額)*/";
//  $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
//  preg_match($pattern,$rowdata["price"],$match);
//  print_r($match);
//  preg_match($pattern,"半額",$match);
//  print_r($match);
//  preg_match($pattern,"P10倍",$match);
//  print_r($match);
//  preg_match($pattern,"4割引",$match);
//  print_r($match);
//  return;
//  $url="test.php";
//  $item=$html;
//  $item=str_replace("__LINK__",$url,$item);
//  $item=str_replace("__SNAME__",$rowdata["sname"],$item);
//  $item=str_replace("__TANI__",$rowdata["tani"],$item);
//  $item=str_replace("__PRICE__",$rowdata["price"],$item);
//  $item=str_replace("__EN__","円",$item);
//  $item=str_replace("__NOTICE__",$rowdata["notice"],$item);
//  $item=str_replace("__LASTSALE__",$rowdata["lastsale"],$item);
//  echo $item;
// }//foreach
 return;

 echo "<pre>";
 $db->getJanItem("0000000000215");
 print_r($db->items);


 $db->getClsItem("10101");
 print_r($db->items);

 $db->getLinItem(1);
 print_r($db->items);

 $db->getClsList(1);
 print_r($db->items);

 $db->getLinList();
 print_r($db->items);

 $db=new ML();
 $db->saleday="2012/11/02";
 $db->set2osusume();
 $db->getMailItem();
 print_r($db->items);

 $db=new ML();
 $db->saleday="2012/11/02";
 $db->getMailItem();
 print_r($db->items);

 $db->getDayList();
 print_r($db->items);

 $db->getItemList();
 print_r($db->items);

 

 $db->saleday="2012/11/16";
 $db->getCalendar();
 print_r($db->items);

 $db->getClsItem(60401);
 print_r($db->items);

 $db->getLinItem(1);
 print_r($db->items);

 $db->getItemList();
 print_r($db->items);

 $db->getClsList(1);
 print_r($db->items);

 $db->getLinList();
 print_r($db->items);



 echo "</pre>";
 echo "success2";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
</body>
</html>
