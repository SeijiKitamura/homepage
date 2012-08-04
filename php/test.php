<?php
require_once("./db.class.php");
$db=new DB();
echo "<pre>";
print_r($db->CreateTable(TB_LINMAS));
?>
