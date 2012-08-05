<?php
require_once("./janmas.class.php");
try{
$db=new JANMAS();
echo "<pre>";
$db->getLinItems(4969503009643);
print_r($db->items);
}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
