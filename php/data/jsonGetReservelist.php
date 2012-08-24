<?php
require_once("../reserve.class.php");
try{
 $db=new RS();
 $db->getItemsList();
 echo json_encode($db->items);
}//try
catch(Exception $e){
 echo "エラー".$e->getMessage();
}//catch
?>
