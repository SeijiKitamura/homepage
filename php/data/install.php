<?php
require_once("../db.class.php");
try{
 $db=new DB();
 echo "<pre>";
 print_r($db->CreateTable(TB_MAILLIST));
 echo "</pre>";
}
catch(Exception $e){
 echo "エラー：".$e->getMessage();
}

?>
