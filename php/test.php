<?php
require_once("mail.class.php");
try{
 //インスタンス
 $db=new ML();
 $db->sendMail("seiji.kitamura@gmail.com","テスト","できるかな？");
 echo "success";
} 
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
