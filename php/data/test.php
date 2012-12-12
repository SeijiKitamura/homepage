<?php
require_once("import.class.php");
try{
 echo "success";
 $db=new ImportData();
 echo "<pre>";
 $db->setPageConf();
 //print_r($db->items);
 echo "</pre>";
 echo "success";

}
catch(Exception $e){
 echo $e->getMessage();
}
?>
