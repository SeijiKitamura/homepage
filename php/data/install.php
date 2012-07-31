<?php
require_once("../db.class.php");
try{
 echo "success";
 $db=new DB();
 echo "<pre>";
 print_r($db->CreateTable());
 echo "</pre>";
}
catch(Exception $e){
 echo "エラー：".$e->getMessage();
}

?>
