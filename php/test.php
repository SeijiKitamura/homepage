<html>
<head>
 <meta charset="utf-8">
</head>
<body>
<?php
require_once("tirasi.class.php");
require_once("calendar.class.php");

try{
 echo "<pre>";
 echo "success";

 //インスタンス
 $db=new CL();
 $db->saleday="2012/11/16";
 $db->getMonthCount();
 echo $db->items."\n";

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



 $db=new TIRASI();
 $db->flg0=734;
 $db->saleday="2012/11/29";

 $db->getJanItem(4979754557176);
 print_r($db->items);

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
 echo "success2";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
</body>
</html>
