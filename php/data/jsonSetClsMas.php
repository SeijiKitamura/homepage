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
 $data["clsmas"]=$db->items;
 //$db=new CLSMAS();
 $db=new CLSMAS();
 $db->setDataLIN();
 $data["linmas"]=$db->items;
 //JSONで返す
 echo json_encode($data);
}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
