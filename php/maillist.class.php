<?php
require_once("db.class.php");
require_once("function.php");

class MAILLIST extends db{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報

 function __construct(){
  parent::__construct();
 }//__construct

 public function setMail($hiduke,$title=null,$main=null){
  //引数チェック
  if(! CHKDATE($hiduke)){
   throw new exception("日付を確認してください。");
  }
  try{
   $this->BeginTran();
   $this->updatecol=array("hiduke"=>$hiduke,
                          "title" =>$title,
                          "main"  =>$main);
   $this->from=TB_MAILLIST;
   $this->where="hiduke='".$hiduke."'";
   $this->update();
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }
 }//setMail
}
?>
