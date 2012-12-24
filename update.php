<?php
require_once("import.class.php");

try{
 //インスタンス生成
 $db=new ImportData();
 echo "更新処理開始<br/>";
 try{ $db->setItem();}    
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setCal();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setMailItem();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setGoyoyaku(); }
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setPageConf();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setLinMas();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 try{ $db->setClsMas();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
// header("location:".HOME."index.php");
}
catch(Exception $e){
 echo $e->getMessage()."<br />";
 echo "更新処理を中止しました";
}
?>
