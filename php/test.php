<?php
require_once("tirasi.class.php");
try{
 //インスタンス
 echo "success";
 $db=new TIRASI();
 echo "success2";
 echo "<pre>";
  print_r($db->getData());
 echo "</pre>";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
