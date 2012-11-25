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
// ファイル名定数(これがそのままテーブル名となる)
//----------------------------------------------------------//
define("CAL"      ,"calendar");          //カレンダー
define("TITLES"   ,"tirasititle");       //チラシタイトル
define("ITEMS"    ,"tirasiitem");        //チラシデータ
define("JANMAS"   ,"janmas");            //単品マスタ
define("CLSMAS"   ,"clsmas");            //クラスマスタ
define("LINMAS"   ,"linmas");            //部門マスタ
define("RESERVE"  ,"reserve");           //ご予約商品マスタ
define("USER"     ,"usermas");           //ご客様マスタ
define("MAILLIST" ,"maillist");          //メール
define("MAILITEMS","mailitems");         //メールアイテム
//---------------------------------------------------//

//---------------------------------------------------//
// ファイルパス系定数
//---------------------------------------------------//
define("JQUERY"     ,JSDIR."jquery.js");
define("CALCSV"     ,DATADIR.CAL.".csv");      //カレンダー
define("TITLECSV"   ,DATADIR.TITLES.".csv");   //チラシタイトル
define("ITEMCSV"    ,DATADIR.ITEMS.".csv");    //チラシデータ
define("JANCSV"     ,DATADIR.JANMAS.".csv");   //単品マスタ
define("CLSCSV"     ,DATADIR.CLSMAS.".csv");   //クラスマスタ
define("LINCSV"     ,DATADIR.LINMAS.".csv");   //部門マスタ
define("RESERVECSV" ,DATADIR.RESERVE.".csv");   //ご予約商品マスタ
//---------------------------------------------------//


//---------------------------------------------------//
// DB 接続系定数
//---------------------------------------------------//
 define("DBHOST"  ,"172.16.0.13");
 define("DBNAME"  ,"homepage");
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
define("TB_RESERVE"     ,TABLE_PREFIX.RESERVE);   //ご予約商品マスタ
define("TB_USER"        ,TABLE_PREFIX.USER);      //お客様マスタ
define("TB_MAILLIST"    ,TABLE_PREFIX.MAILLIST);  //メール
define("TB_MAILITEMS"   ,TABLE_PREFIX.MAILITEMS); //メールアイテム

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
                          ,"salestart" =>array(  "type"  =>"date"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"'0000-00-00'"
                                               ,"primary"=>""
                                               ,"local"  =>"販売開始日"
                                              )//salestart
                          ,"lastsale" =>array(  "type"   =>"date"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"'0000-00-00'"
                                               ,"primary"=>""
                                               ,"local"  =>"最終販売日"
                                              )//lastsale
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
              ,TB_RESERVE=>array(
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
                            )//TB_RESERVE
              ,TB_USER=>array(
                             "usermail"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>1
                                               ,"local"  =>"メールアドレス"
                                              )//usermail
                            ,"password"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"パスワード"
                                              )//password
                            ,"name"    =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"お名前"
                                              )//name    
                            ,"address" =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"ご住所"
                                              )//address 
                           ,"tel"      =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"お電話"
                                              )//tel
                           ,"daddress" =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"お届先ご住所"
                                              )//daddress 
                           ,"dtel"     =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"お届先電話"
                                              )//dtel
                           ,"rname"    =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"領収書お名前"
                                              )//rname
                           ,"checkcode"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"チェックコード"
                                              )//checkcode
                            )//TB_USER
              ,TB_MAILLIST=>array(
                               "id"    =>array( "type"   =>"int"
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
                                                 ,"local"  =>"販売日"
                                                )//hiduke    
                             ,"title"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"タイトル"
                                                )//title    
                             ,"main"     =>array( "type"   =>"varchar(2000)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"本文"
                                                )//main    
 
                            )//TB_MAILLIST
              ,TB_MAILITEMS=>array(
                               "id"    =>array( "type"   =>"int"
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
                                                 ,"local"  =>"販売日"
                                                )//hiduke    
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売タイプ"
                                                )//hiduke    
                             ,"jcode"    =>array( "type"   =>"varchar(14)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"JANコード"
                                                )//jcode   
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

                            )//TB_MAILITEMS
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
                 ,TB_RESERVE=>array(
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
                                    )//TB_RESERVE
                 );//CSVCOLUMNS
//---------------------------------------------------//

//---------------------------------------------------//
// メール系定数
//---------------------------------------------------//
define("EMAILUSERNAME","order@kita-grp.co.jp"); //メールユーザー名
define("EMAILPASS"    ,"36T67238");             //メールパスワード
define("EMAIL"        ,EMAILUSERNAME);          //メールアドレス
define("USERNAME"     ,"スーパーキタムラ");     //メール差出人名
$SUBJECT=<<<EOF
【スーパーキタムラ】メールアドレス登録完了のお知らせ
EOF;

$WELCOMMSG=<<<EOF
スーパーキタムラからのお知らせです。

___MD5___  

ホームページにてご入力いただいたメールアドレスを登録しました。
上記URLをクリックしてユーザー登録を続けてください。

すでにご登録いただいておりますお客様はパスワードを初期化しました。
上記URLをクリックして、画面に表示されているパスワード欄に新しいパスワードを入力後,住所お電話番号の変更が可能となります。


このメールに心当たりがない場合:
お手数をかけますがこのメールを破棄していただきますようお願いいたします。
このメールは弊社ホームページ上で、お客様が入力されたメールアドレスへ自動にて送信をしております。 一定時間を過ぎて登録が完了しない場合、自動でこのメールアドレスを削除いたします。弊社システムにこのメールアドレスが残ることはございません。

お問い合わせ先:
ご質問、不明な点等ございましたら下記メールアドレスまでご連絡ください。

メールアドレス:super@kita-grp.co.jp

メールアドレスご登録ありがとうございました。
スーパーキタムラ
EOF;

//---------------------------------------------------//
// データ表示系定数                                  //
//---------------------------------------------------//
define("JANMASLIMIT",30);//tirasiitem.php,item.php 「こんな商品･･」表示数 
define("NAVISTART",5);   //item.php 「こんな商品･･」表示数 
define("NAVISPAN",10);     //item.php 「こんな商品･･」表示数 
define("SALESTART",30); //新商品の抽出基準。本日より何日前までを新商品とするか
?>
