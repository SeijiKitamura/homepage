<?php
require_once("auth.class.php");
try{
 $db=new AUTH();
 $db->getUser($_POST["mail"],$_POST["pass"]);
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>

