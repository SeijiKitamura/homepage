<?php
require_once("../maillist.class.php");
try{
 echo "success";
 print_r($_POST);

 $hiduke=$_POST["hiduke"];
 $title =$_POST["mailtitle"];
 $main  =$_POST["mailmain"];
 
 $db=new MAILLIST();
 $db->setMail($hiduke,$title,$main);
 echo "<pre>";
 echo htmlspecialchars($main);
 echo "</pre>";
 echo "登録しました";
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
