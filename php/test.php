<?php
require_once("./janmas.class.php");
try{
 //インスタンス
 $db=new JANMAS(); //janmas.class.php参照
 
 //DB登録
 $db->setData();
 echo "<pre>";
 print_r($db->items["errdata"]);
 echo "</pre>";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
