<?php
//-----------------------------------------------------------------//
//  jsonSetTirasiItem.php                                            //
//  アップロードしたCSVファイルをDBへ登録                          //
//  返り値:
//         JSON[data]   CSVデータ                          
//         JSON[local]  列名                          
//         JSON[status] データの状態 true 正常 false エラー    
//-----------------------------------------------------------------//

require_once("../tirasi.class.php");
try{
 //アップロードされたファイルを所定ディレクトリへコピー(function.php)
 UPLOADCSV(TITLES); //(function.php)

 //インスタンス
 $db=new TIRASI(); //calendar.class.php参照
 
 //DB登録
 $db->setDataItem();

 //JSONで返す
 echo json_encode($db->items);

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
