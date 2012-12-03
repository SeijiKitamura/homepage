<?php
require_once("import.class.php");
try{
 echo "success";
 $db=new ImportData();
 echo "<pre>";
 $db->setTitle();
 print_r($db->items);

 $db->setItem();
 print_r($db->items);

 $db->setCal();
 print_r($db->items);

 $db->setMailItem();
 print_r($db->items);
 echo "</pre>";
 echo "success";

}
catch(Exception $e){
 echo $e->getMessage();
}
?>
