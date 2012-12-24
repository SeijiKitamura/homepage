<?php
require_once("./php/calendar.class.php");
require_once("./php/html.class.php");
try{
 $db=new CL();
 echo "call";
 $db->setHTML();
 echo "success";
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
