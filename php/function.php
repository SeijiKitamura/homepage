<?php
//-------------------------------------------//
// CSV 値チェック                            //
// CSVファイルを読み込んで配列を返す         //
// 注意:元データに[err]が付きます。          //
//-------------------------------------------//
function CHKDATA($csvfilepath,$table){
 global $TABLES;
 global $CSVCOLUMNS;
 
 //該当テーブルの列情報をゲット
 $col=$TABLES[$table];
 if(! $col) throw new exception("テーブル情報がありません");

 //該当CSVファイルの列情報をゲット
 $csv=$CSVCOLUMNS[$table];
 if(! $csv) throw new exception("CSV列情報がありません");

 //ファイル読み込み
 if(($fl=fopen($csvfilepath,"r"))===FALSE) throw new exception("元データがありません");

 //配列へCSVデータを追加
 while($line=fgets($fl)){
  $line=str_replace("\n","",$line);
  $csvdata[]=explode(",",$line);
 }//while
 if(! $csvdata) throw new exception("CSVデータがありません");

 //列数を確認
 if(count($csvdata[0])!==count($csv)) throw new exception("CSVの列数が違います");
 
 //データチェック
 $status=true;
 for($i=0;$i<count($csvdata);$i++){
  $flg=1; //エラーフラグ
  $msg="OK";
  for($j=0;$j<count($csvdata[$i]);$j++){
   //type、dataをゲット
   $type=$col[$csv[$j]]["type"];
   $data=$csvdata[$i][$j];

   //値チェック
   if(! CHKTYPE($type,$data)){
    $msg=$col[$csv[$j]]["local"]."の値が不正です";
    $flg=0;
    $status=false;
   }
  }//for $j

  //エラーメッセージ付加
  $csvdata[$i]["err"]=$msg;
 }//for $i

 //列名をセット
 for($i=0;$i<count($csv);$i++){
  $items["local"][]=$col[$csv[$i]]["local"];
 }//for

 $items["data"]  =$csvdata;
 $items["status"]=$status;
 $items["local"][]="エラー内容";

 //return $csvdata;
 return $items;
}
//-------------------------------------------//

//-------------------------------------------//
//       DB列 値チェック                     //
//-------------------------------------------//
function CHKTYPE($type,$data){
 //date型チェック
 if($type==="date"){
  if(! CHKDATE($data)) return false;
 }

 //int型チェック
 if($type==="int" || $type==="bigint"){
  $pattern="/^[0-9]+$/";
  preg_match($pattern,$data,$match);
  if(! $match) return false;
 }

 //varchar型
 //チェックしたい内容を記入

 //timestamp型
 //チェックしたい内容を記入

 return true;
}
//-------------------------------------------//

//-------------------------------------------//
//                 日付チェック              //
//-------------------------------------------//
function  CHKDATE($hiduke){
 //正規表現チェック
 $pattern="/^(20[0-9]{2})[-\/]?([0-1]?[0-9]{1})[-\/]?([0-3]?[0-9]{1})$/";
 preg_match($pattern,$hiduke,$match);
 if(! $match) return false;

 //日付の正当性をチェック
 $ts=strtotime($hiduke);
 if(date("Y",$ts)!=$match[1] || date("m",$ts)!=$match[2] || date("d",$ts)!=$match[3]) return false;
 return true;
}

//-------------------------------------------//
//        CSVアップロード                    //
//-------------------------------------------//
function UPLOADCSV($file){

 $filepath=DATADIR.$file.".csv";
 //アップロードファイル容量チェック

 //アップロードされたファイルを所定ディレクトリへコピー
 if(! move_uploaded_file($_FILES[$file]["tmp_name"],$filepath)){
  throw new exception("ファイルアップロードに失敗しました");
 }


 //ファイル読み込み
 if(! $data=file_get_contents($filepath)) throw new exception("ファイル読み込みに失敗しました");
 //文字コード変換
 if(! $data=mb_convert_encoding($data,"UTF-8","SJIS")) throw new exception("文字コード変換に失敗しました");

 //改行コード変換
 if(! $data=str_replace("\r\n","\n",$data)) throw new exception("改行コード変換に失敗しました");

 //ファイル保存
 if(! file_put_contents($filepath,$data)) throw new exception("ファイルの保存に失敗しました"); 

 //パーミッション変更確認
 if(! chmod($filepath,0644)) throw new exception("ファイル所有者変更に失敗しました");


 return true;
}//UPLOADCSV



$ary=array("test"=>1,
           "last"=>3);

//ファンクション内で使用するグローバル関数
function TEST(){
 //echo "class". " ".CSSDIR;
 global $ary;
 print_r($ary);
}

//クラス内で使用するグローバル関数
class TEST2{
 public static function test(){
  print_r($GLOBALS["ary"]);
 }
}
?>
