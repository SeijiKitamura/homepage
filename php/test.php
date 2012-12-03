<html>
<head>
 <meta charset="utf-8">
</head>
<body>
<?php
require_once("tirasi.class.php");
try{
 //インスタンス
 echo "success";
 $db=new TIRASI();
 $db->flg0=734;
 $db->saleday="2012/11/29";
 echo "<pre>";

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
