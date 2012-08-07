<?php
//-----------------------------------------------------------------//
//  jsonSetJanMas.php                                            //
//  アップロードしたCSVファイルをDBへ登録                          //
//  返り値:
//         JSON[data]   CSVデータ                          
//         JSON[local]  列名                          
//         JSON[status] データの状態 true 正常 false エラー    
//-----------------------------------------------------------------//

require_once("../janmas.class.php");
try{
 //アップロードされたファイルを所定ディレクトリへコピー(function.php)
 UPLOADCSV(JANMAS); //(function.php)

 //インスタンス
 $db=new JANMAS(); //janmas.class.php参照
 
 //DB登録
 $db->setData();

 //データは件数のみ返す(JanMas専用)
 $json["data"]=count($db->items["data"])-count($db->items["errdata"]);
 $json["status"]=$db->items["status"];
 $json["local"]=$db->items["local"];
 $json["errdata"]=$db->items["errdata"];

 //JSONで返す
 echo json_encode($json);

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
