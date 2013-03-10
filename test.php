<?php
require_once("./php/db.class.php");
try{
 $db=new DB();
 $db->CreateTable(TB_JANMAS);
 $db=new DB();
 $db->CreateTable(TB_CLSMAS);
 $db=new DB();
 $db->CreateTable(TB_LINMAS);
 $db=new DB();
 $db->CreateTable(TB_SALEITEMS);
 $db=new DB();
 $db->CreateTable(TB_PAGECONF);
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
