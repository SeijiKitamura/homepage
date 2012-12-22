<?php
require_once("db.class.php");

try{
 //テーブル作成
 $db->createtable(TB_JANMAS);
 $db->createtable(TB_CLSMAS);
 $db->createtable(TB_LINMAS);
 $db->createtable(TB_SALEITEMS);
 $db->createtable(TB_PAGECONF);
 
}//try
catch(Exception $e){
 echo $e->getMessage();
}
?>
