<?php
//---------------------------------------------------//
// デバックモード(true で「する」、falseで「しない」 //
//---------------------------------------------------//
define("DEBUG",true);
//---------------------------------------------------//


//---------------------------------------------------//
// ディレクトリ系定数
//---------------------------------------------------//
define("SITEDIR","/var/www/hp/");  //このサイトのトップディレクトリ
define("IMGDIR" ,SITEDIR."img/");  //画像保存場所
define("JSDIR"  ,SITEDIR."js/");   //JavaScript Jquery保存場所
define("PHPDIR" ,SITEDIR."php/");  //PHP
define("CSSDIR" ,SITEDIR."css/");  //css
define("DATADIR",PHPDIR."data/"); //更新データ
//---------------------------------------------------//

//----------------------------------------------------------//
// ファイル名定数(ここを変更した場合jQuery側でも変更すること)
//----------------------------------------------------------//
define("CAL"     ,"calendar");          //カレンダー
define("TITLES"  ,"tirasititle");       //チラシタイトル
define("ITEMS"   ,"tirasiitem");        //チラシデータ
define("JANMAS"  ,"janmas");            //単品マスタ
define("CLSMAS"  ,"clsmas");            //クラスマスタ
define("LINMAS"  ,"linmas");            //部門マスタ
define("SPECIAL" ,"special");           //ご予約商品マスタ
//---------------------------------------------------//

//---------------------------------------------------//
// ファイルパス系定数
//---------------------------------------------------//
define("JQUERY"  ,JSDIR."jquery.js");
define("CALCSV"  ,DATADIR.CAL.".csv");      //カレンダー
define("TITLECSV",DATADIR.TITLES.".csv");   //チラシタイトル
define("ITEMCSV" ,DATADIR.ITEMS.".csv");    //チラシデータ
define("JANCSV"  ,DATADIR.JANMAS.".csv");   //単品マスタ
define("CLSCSV"  ,DATADIR.CLSMAS.".csv");   //クラスマスタ
define("LINCSV"  ,DATADIR.LINMAS.".csv");   //部門マスタ
define("SPECIALCSV",DATADIR.SPECIAL.".csv");   //ご予約商品マスタ
//---------------------------------------------------//


//---------------------------------------------------//
// DB 接続系定数
//---------------------------------------------------//
 define("DBHOST"  ,"localhost");
 define("DBNAME"  ,"html2");
 define("DBUSER"  ,"kennpin1");
 define("DBPASS"  ,"1");

//---------------------------------------------------//
// DB テーブル名定数
//---------------------------------------------------//
define("TABLE_PREFIX"   ,"he_");                  //プレフィックス
define("TB_CAL"         ,TABLE_PREFIX.CAL);       //カレンダー
define("TB_TITLES"      ,TABLE_PREFIX.TITLES);    //チラシタイトル
define("TB_ITEMS"       ,TABLE_PREFIX.ITEMS);     //チラシデータ
define("TB_JANMAS"      ,TABLE_PREFIX.JANMAS);    //単品マスタ
define("TB_CLSMAS"      ,TABLE_PREFIX.CLSMAS);    //クラスマスタ
define("TB_LINMAS"      ,TABLE_PREFIX.LINMAS);    //部門マスタ
define("TB_SPECIAL"     ,TABLE_PREFIX.SPECIAL);   //ご予約商品マスタ

//---------------------------------------------------//
// DB テーブル列系定数
//---------------------------------------------------//
define("IDATE"   ,"idate"); //作成日時。各テーブルに必ずセットされる。
define("CDATE"   ,"cdate"); //更新日時。各テーブルに必ずセットされる。
define("IDATESQL"," ".IDATE." timestamp not null default current_timestamp");
define("CDATESQL"," ".CDATE." timestamp     null");
 //---------------------------------------------------//

//---------------------------------------------------//
// テーブル情報                                      //
//---------------------------------------------------//

$TABLES=array(TB_TITLES=>array(
                              "tirasi_id"=>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>1
                                                 ,"local"  =>"チラシ番号"
                                                )//tirasi_id
                             ,"hiduke"   =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"投函日"
                                                )//hiduke    
                             ,"title"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"タイトル"
                                                )//title    
                            ,"view_start"=>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"開始日"
                                                )//view_start
                            ,"view_end"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"終了日"
                                                )//view_end  
                            )//TB_TITLES
            ,TB_ITEMS=>array(
                              "id"       =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>"auto"
                                                 ,"default"=>"0"
                                                 ,"primary"=>1
                                                 ,"local"  =>"番号"
                                                )//id
                             ,"tirasi_id"=>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"チラシ番号"
                                                )//tirasi_id
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"idxnum" =>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saletype
                             ,"subtitle" =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"サブタイトル"
                                                )//saletype
                             ,"hiduke"   =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"日付"
                                                )//hiduke  
                             ,"lincode"  =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"部門番号"
                                                )//lincode 
                             ,"clscode"  =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"クラスコード"
                                                )//clscode 
                             ,"jcode"    =>array( "type"   =>"varchar(14)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"JANコード"
                                                )//jcode   
                             ,"sname"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"商品名"
                                                 )//sname   
                             ,"maker"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                             ,"tani"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                             ,"baika"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"売価"
                                                )//baika   
                             ,"notice"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice  
                            ,"specialflg"=>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"目玉"
                                                )//specialflg
                            )//TB_ITEMS
             ,TB_CAL=>array(
                              "id"       =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>"auto"
                                                 ,"default"=>"0"
                                                 ,"primary"=>1
                                                 ,"local"  =>"番号"
                                                )//id
                             ,"hiduke"   =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"日付"
                                                )//hiduke  
                             ,"title"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"タイトル"
                                                )//title    
                             ,"rate"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"割引率"
                                                )//rate     
                             ,"notice"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice   
                             ,"clscode"  =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"クラスコード"
                                                )//clscode  
                            )//calendar  
   
              ,TB_JANMAS=>array(
                                "jcode"=>array( "type"   =>"varchar(14)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>1
                                               ,"local"  =>"JANコード"
                                              )//jcode
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//clscode
                             ,"sname"  =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"商品名"
                                              )//sname
                           ,"stdprice" =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"標準売価"
                                              )//stdprice
                          ,"price"    =>array(  "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"売価"
                                              )//price
                          ,"lastsale" =>array(  "type"   =>"date"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"'0000-00-00'"
                                               ,"primary"=>""
                                               ,"local"  =>"最終販売日"
                                              )//price
                            )//TB_JANMAS
              ,TB_CLSMAS=>array(
                              "clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//clscode
                             ,"clsname"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"クラス名"
                                              )//clsname
                             ,"lincode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"部門番号"
                                              )//lincode
                            )//TB_CLSMAS
              ,TB_LINMAS=>array(
                              "lincode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"部門番号"
                                              )//lincode
                             ,"linname"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"部門名"
                                              )//linname
                             ,"dpscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"メジャー番号"
                                              )//dpscode
                            )//TB_LINMAS
              ,TB_SPECIAL=>array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id
                              ,"grp1"  =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp1"
                                              )//grp1
                            ,"grp1name"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp1名"
                                              )//grp1name
                              ,"grp2"  =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp2"
                                              )//grp2
                            ,"grp2name"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp2名"
                                              )//grp2name
                              ,"grp3"  =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp3"
                                              )//grp3
                            ,"grp3name"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"Grp3名"
                                              )//grp3name
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//jcode
                               ,"jcode"=>array( "type"   =>"varchar(14)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>'0'
                                               ,"primary"=>""
                                               ,"local"  =>"JANコード"
                                              )//jcode
                               ,"sname"=>array(   "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"商品名"
                                                 )//sname   
                               ,"maker"=>array(   "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                               ,"tani" =>array(   "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                               ,"baika"  =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"売価"
                                                )//baika   
                               ,"notice" =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice  
                            ,"view_start"=>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"開始日"
                                                )//view_start
                            ,"view_end"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"終了日"
                                                )//view_end  
                            ,"flg"       =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"表示"
                                                )//flg
                            )//TB_SPECIAL
            );//TABLES

//---------------------------------------------------//

//---------------------------------------------------//
// CSV並び順配列
//---------------------------------------------------//
$CSVCOLUMNS=array( TB_CAL   =>array( "hiduke"
                                    ,"title"
                                    ,"rate"
                                    ,"notice"
                                    ,"clscode"
                                   )//TB_CAL
                  ,TB_TITLES=>array( "tirasi_id"
                                    ,"hiduke"
                                    ,"title"
                                    ,"view_start"
                                    ,"view_end"
                                   )//TB_TITLES
                  ,TB_ITEMS =>array( "tirasi_id"
                                    ,"hiduke"
                                    ,"lincode"
                                    ,"clscode"
                                    ,"jcode"
                                    ,"maker"
                                    ,"sname"
                                    ,"tani"
                                    ,"baika"
                                    ,"notice"
                                    ,"subtitle"
                                    ,"saletype"
                                    ,"specialflg"
                                   )//TB_ITEMS
                  ,TB_JANMAS=>array(
                                     "jcode"
                                    ,"clscode"
                                    ,"sname"
                                    ,"stdprice"
                                    ,"price"
                                    ,"lastsale"
                                   )//TB_JANMAS
                  ,TB_CLSMAS=>array(
                                     "clscode"
                                    ,"clsname"
                                    ,"lincode"
                                   )//TB_CLSMAS
                  ,TB_LINMAS=>array(
                                     "lincode"
                                    ,"linname"
                                    ,"dpscode"
                                   )//TB_LINMAS
                 ,TB_SPECIAL=>array(
                                     "grp1"
                                    ,"grp1name"
                                    ,"grp2"
                                    ,"grp2name"
                                    ,"clscode"
                                    ,"jcode"
                                    ,"sname"
                                    ,"maker"
                                    ,"tani"
                                    ,"baika"
                                    ,"notice"
                                    ,"view_start"
                                    ,"view_end"
                                    ,"flg"
                                    )//TB_SPECIAL
                 );//CSVCOLUMNS
//---------------------------------------------------//

//---------------------------------------------------//
// データ表示系定数                                  //
//---------------------------------------------------//
define("JANMASLIMIT",30);//tirasiitem.php,item.php 「こんな商品･･」表示数 
define("NAVISTART",5);   //item.php 「こんな商品･･」表示数 
define("NAVISPAN",10);     //item.php 「こんな商品･･」表示数 
?>
