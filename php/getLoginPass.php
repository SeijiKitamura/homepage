<?php
require_once("auth.class.php");
try{
 $db=new AUTH();
 $db->getUser($_POST["usermail"],$_POST["password"]);
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>

