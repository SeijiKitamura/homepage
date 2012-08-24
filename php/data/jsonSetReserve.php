<?php
//-----------------------------------------------------------------//
//  jsonSetSpecial.php                                            //
//  アップロードしたCSVファイルをDBへ登録                          //
//  返り値:
//         JSON[data]   CSVデータ                          
//         JSON[local]  列名                          
//         JSON[status] データの状態 true 正常 false エラー    
//-----------------------------------------------------------------//
require_once("../reserve.class.php");
try{

 //アップロードされたファイルを所定ディレクトリへコピー(function.php)
 UPLOADCSV(RESERVE); //(function.php)

 //インスタンス
 $db=new RS();

 //データチェック
 $db->setData();
 //DB登録
 
 //JSONで返す
 echo json_encode($db->items);
}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
