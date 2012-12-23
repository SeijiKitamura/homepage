<?php
require_once("db.class.php");

try{
 //テーブル作成
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

 chdir(DATADIR);
 require_once("import.class.php");
 $db=new ImportData();
 $db->setJanMas();
 $db->setCal();
 $db->setMailItem();
 $db->setGoyoyaku();
 $db->setPageConf();
 $db->setLinMas();
 $db->setClsMas();
}//try
catch(Exception $e){
 echo $e->getMessage();
}
?>
