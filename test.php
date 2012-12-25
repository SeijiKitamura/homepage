<?php
require_once("./php/calendar.class.php");
try{
 $db=new CL();
 echo "call";
 $db->getMonthList();
 echo "call";
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";
 echo "call";
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
