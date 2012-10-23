<?php
//----------------------------------------------------------//
//  auth.class.php 
//  お客様マスタ系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//----------------------------------------------------------//
require_once("mail.class.php");
require_once("db.class.php");
require_once("function.php");

class AUTH extends DB{
 public  $items;   //データを格納
 private $columns;//テーブル情報

 function __construct(){
  parent::__construct();
 }//__construct

 //---------------------------------------------------------//
 // メールアドレスチェック
 //---------------------------------------------------------//
 public function checkMail($mail){
  //データ初期化
  $this->items=null;

  //メールアドレスチェック(@が入っていればよしとする)
  if(! preg_match("/[@]/",$mail)){
   throw new exception("emailアドレスが正しくありません");
  }

  //checkcodeにmd5を登録して返す(登録済みならパスワード初期化)
  $md5=GETCHECKCODE($mail);
  $this->updatecol=array("usermail" =>$mail,
                         "password" =>"",
                         "checkcode"=>$md5);
  $this->from=TB_USER;
  $this->where="usermail='".$mail."'";
  $this->update();
  sendAuthMail($mail,$md5);
  return $md5;
 }//checkMail

 //---------------------------------------------------------//
 //---------------------------------------------------------//
 public function checkMD5($md5){
  if(! $md5) throw new exception("メールアドレス未登録");

  $this->select="usermail,name,address,tel,daddress,dtel,rname,checkcode,".CDATE;
  $this->from =TB_USER;
  $this->where="checkcode='".$md5."'";
  $this->getArray();
  $this->items=$this->ary[0];
  return true;
 }//checkMD5

 //---------------------------------------------------------//
 // ユーザー登録
 //---------------------------------------------------------//
 public function UserAdd($user){
  //引数チェック
  if(! preg_match("/[@]/",$user["usermail"])){
   throw new exception("メールが正しくありません。".$user["usermail"]);
  }//if

  if(! preg_match("/^[0-9a-zA-Z]{3,}$/",$user["password"])){
   throw new exception("パスワードが正しくありません");
  }//if

  if(! $user["name"]){
   throw new exception("ユーザー名を入力してください");
  }//if

  if($user["tel"] && ! preg_match("/[0-9]{2,3}[\-]?[0-9]{3,4}[\-]?[0-9]{3,4}$/",$user["tel"])){
   throw new exception("電話番号が正しくありません");
  }//if

  if(! preg_match("/[0-9a-z]{32}/",$user["checkcode"])){
   throw new exception("予想していないエラーです");
  }//if

  //md5生成
  $user["password"]=md5($user["usermail"].$user["password"].SITEDIR);

  //既存データ確認
  $this->select="usermail,password";
  $this->from=TB_USER;
  $this->where =" usermail='".$user["usermail"]."'";
  $this->where.=" and checkcode='".$user["checkcode"]."'";
  $this->items=$this->getArray();
  if($this->items[0]["password"] && $this->items[0]["password"]!==$user["password"]){
   throw new exception("パスワードが違います");
  }//if

  //データ更新(checkcode更新する)
  $ary=array("usermail" =>$user["usermail"],
             "password" =>$user["password"],
             "name"     =>$user["name"],
             "address"  =>$user["address"],
             "tel"      =>$user["tel"],
             "checkcode"=>GETCHECKCODE($user["usermail"].$user["password"])
            );

  $this->updatecol=$ary;
  $this->from=TB_USER;
  $this->where="usermail='".$user["usermail"]."'";
  $this->update();

  //更新したデータを返す
  $this->select="usermail,name,address,tel,checkcode";
  $this->from=TB_USER;
  $this->where="usermail='".$user["usermail"]."'";
  $this->items=$this->getArray();
 }//UserAdd

 //---------------------------------------------------------//
 // パスワード認証
 //---------------------------------------------------------//
 public function getUser($mail,$pass){
  $pass=GETPASS($mail.$pass);

  $this->select="usermail,password";
  $this->from=TB_USER;
  $this->where =" usermail='".$mail."'";
  $this->items=$this->getArray();
  if(! $this->items) throw new exception("メールアドレス未登録です");
  if($pass!==$this->items[0]["password"]) throw new exception("パスワード、メールアドレスが違います");

  //checkcode更新
  $checkcode=GETCHECKCODE($mail.$pass);
  $this->updatecol=array("checkcode"=>$checkcode);
  $this->from=TB_USER;
  $this->where =" usermail='".$mail."'";
  $this->update();

  echo $mail.":".$checkcode;
 }//getUser

 //---------------------------------------------------------//
 // ユーザー認証
 //---------------------------------------------------------//
 public function getAuth($mail,$checkcode){
  //登録チェック
  $this->select="usermail,name,address,tel,daddress,dtel,rname,checkcode,".CDATE;
  $this->from=TB_USER;
  $this->where="usermail='".$mail."'";
  $this->items=$this->getArray();
  if(! $this->items) throw new exception("登録されていません");

  //更新日チェック
  $cdate=strtotime($this->items[0][CDATE]);
  $d=strtotime("-2days",date("Y-m-d"));
  if($cdate<$d) throw new exception("再ログインが必要です");

  //認証
  if(trim($this->items[0]["checkcode"])!==trim($checkcode)) throw new exception("もう一度ログインが必要です");

  return true;
 }//getAuth

 //---------------------------------------------------------//
 // ユーザー変更
 //---------------------------------------------------------//
 public function ChangeUser($user){
  //引数チェック
  if(! preg_match("/[@]/",$user["usermail"])){
   throw new exception("メールが正しくありません。".$user["usermail"]);
  }//if

  if($user["newmail"] && ! preg_match("/[@]/",$user["newmail"])){
   throw new exception("メールが正しくありません。".$user["newmail"]);
  }//if

  if($user["oldpass"] && ! preg_match("/^[0-9a-zA-Z]{3,}$/",$user["oldpass"])){
   throw new exception("パスワードが正しくありません");
  }//if

  if($user["password"] && ! preg_match("/^[0-9a-zA-Z]{3,}$/",$user["password"])){
   throw new exception("パスワードが正しくありません");
  }//if
  
 }//ChangeUser
}//AUTH


//---------------------------------------------------------//
// ユーザー認証用メール送信
//---------------------------------------------------------//

function sendAuthMail($mail,$md5){
 global $SUBJECT;
 global $WELCOMMSG;
 preg_match("/.*\//",$_SERVER["HTTP_REFERER"],$match);
 $url=$match[0];
 $url.="userentry.php?auth=".$md5;
 $WELCOMMSG=str_replace("___MD5___",$url,$WELCOMMSG);
 $ml=new ML();
 $ml->sendMail($mail,$SUBJECT,$WELCOMMSG);
}

?>
