<?php
require_once("php/html.class.php");
require_once("php/page.class.php");
try{
 $page="item.php";
 $db=new PAGE();
 $db->getPage($page);
 $html=html::setHead($db->items[0]);
 echo $html;
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
