<?php
require_once("./db.class.php");
try{
 //インスタンス
 $db=new DB();
/*
 $db->CreateTable(TB_JANMAS);
 $db->CreateTable(TB_CLSMAS);
 $db->CreateTable(TB_TITLES);
 $db->CreateTable(TB_ITEMS);
 $db->CreateTable(TB_LINMAS);
 $db->CreateTable(TB_RESERVE);
*/
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
