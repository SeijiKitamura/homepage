<?php
require_once("../config.php");
require_once("../db.class.php");

try{

 $db=new DB();
 $db->createtable(TB_SALEITEMS);
}//try
catch(Exception $e){
 echo $e->getMessage();
}
?>
