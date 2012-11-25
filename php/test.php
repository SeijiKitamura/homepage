<?php
require_once("janmas.class.php");
try{
 //インスタンス
 echo "success";
 $db=new JANMAS();
 echo "success2";
 $db->getNewItem();
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
