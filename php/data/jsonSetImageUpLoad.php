<?php
//-----------------------------------------------------------------//
//  jsonSetImageUpLoad.php                                         //
//  アップロードされた画像サイズ変更する                           //
//  返り値:JANCODE.jpg  変換後の画像ファイル名
//-----------------------------------------------------------------//
require_once("../tirasi.class.php");
try{
 //引数チェック
 if(! $_POST["jcode"] || ! is_numeric($_POST["jcode"])){
  throw new exception("登録されているJANコードが不正です");
 }

 $jcode=$_POST["jcode"];

 //常に同じ名前で保存される 。
 $work=DATADIR."upload";

 //画像取得(import.html inputタグname属性を変更した場合、ここの
 //「upload_」を同様に変更してください
 if(! move_uploaded_file($_FILES["upload_".$jcode]["tmp_name"],$work)){
  throw new exception("ファイルアップロードに失敗しました");
 }

 //shellでコンバート
 $cmd=escapeshellcmd("convert -geometry 120 ".$work." ".IMGDIR.$jcode.".jpg");
 exec($cmd,$err);

 if($err) throw new exception("画像変換に失敗しました");

 //ファイル所有者変更
 if(! chmod(IMGDIR.$jcode.".jpg",0666)) throw new exception("ファイル所有者変更に失敗しました");

 echo $jcode.".jpg";
}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
