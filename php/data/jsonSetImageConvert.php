<?php
//-----------------------------------------------------------------//
//  jsonSetImageConvert.php                                        //
//  外部画像を取り込んで、サイズ変更する                           //
//  返り値:
//         JSON[status] データの状態 true 正常 false エラー    
//         JSON[data]   変換後の画像ファイルパス
//-----------------------------------------------------------------//
require_once("../tirasi.class.php");
try{
 //引数チェック
 if(! $_GET["jcode"] ||! $_GET["imageurl"]) throw new exception("もう一度商品を選択してください");

 $db=new TIRASI();
 $db->ConvertImage($_GET["jcode"],$_GET["imageurl"]);

 echo json_encode($db->items);
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
