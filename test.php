<?php
require_once("php/goyoyaku.class.php");
require_once("php/page.class.php");
try{
 $page=new PAGE();
 $page->setHeader("goyoyaku.php");
 echo "success";
 $db=new GOYOYAKU();
 echo "<pre>";
 $db->getLinList();
 print_r($db->items);

 $db->getClsList(5);
 print_r($db->items);

 $db->getGrpList();
 print_r($db->items);

 $db->getItemList();
 print_r($db->items);
 $item=$db->items["data"][0]["flg0"];
 echo $item;
 $db->getGrpItem($item);
 print_r($db->items);
 echo "success";
 echo "</pre>";
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
