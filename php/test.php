<?php
require_once("maillist.class.php");
try{
 //インスタンス
 echo "success";
 $db=new MAILLIST();
 echo "success2";
 $db->getItemList(1,$_GET["hiduke"]);
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
