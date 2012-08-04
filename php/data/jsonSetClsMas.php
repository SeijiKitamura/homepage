<?php
//-----------------------------------------------------------------//
//  jsonSetClsMas.php                                            //
//  アップロードしたCSVファイルをDBへ登録                          //
//  返り値:
//         JSON[data]   CSVデータ                          
//         JSON[local]  列名                          
//         JSON[status] データの状態 true 正常 false エラー    
//-----------------------------------------------------------------//
require_once("../clsmas.class.php");
try{
 $db=new CLSMAS();

 $db->splitCsv();

 $db->setDataCLS();
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";

 $db=new CLSMAS();
 $db->setDataLIN();
 echo "<pre>";
 print_r($db->items);
 echo "</pre>";
/*
 //インスタンス
 $db=new CL(); //calendar.class.php参照

 //DB登録
 $db->setData();

 //JSONで返す
 echo json_encode($db->items);
*/
}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
