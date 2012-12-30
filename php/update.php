<?php
require_once("import.class.php");
require_once("calendar.class.php");

try{
 //インスタンス生成
 $db=new ImportData();
 echo date("Y-m-d H:i:s")." 更新処理開始<br/>";
 //CSVデータ更新
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
 try{ $db->setPageConf();}
 catch(Exception $e){ echo $e->getMessage()."<br/>"; }
 
 try{
  $db=new CL();
  $db->setHTML();
 }//try
 catch(Exception $e){
  echo $e->getMessage()."<br />";
 }//catch

// header("location:".HOME."index.php");
}
catch(Exception $e){
 echo $e->getMessage()."<br />";
 echo "更新処理を中止しました";
}
?>
