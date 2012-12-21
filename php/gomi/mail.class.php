<?php
require_once("phpmailer/class.phpmailer.php");
mb_language("japanese");
mb_internal_encoding("UTF-8");

class ML extends PHPMailer{
 function __construct(){

  parent::__construct();

  $this->IsSMTP();
  $this->Host="ssl://smtp.gmail.com:465";
  $this->SMTPAuth=TRUE;
  $this->Username=EMAILUSERNAME;
  $this->Password=EMAILPASS;
  $this->CharSet="iso-2022-jp";
  $this->Encoding="7bit";
  $this->From=EMAIL;
  $this->FromName=mb_encode_mimeheader(mb_convert_encoding(USERNAME,"JIS","UTF-8"));
 }//construct

 public function sendMail($to,$subject,$msg){
  $this->AddAddress($to);
  $this->Subject=mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","UTF-8"));
  $this->Body=mb_convert_encoding($msg,"JIS","UTF-8");
  if(! $this->Send()) throw new exception("確認メールの送信に失敗しました");
  return true;
 }//sendMail
}//ML
?>
