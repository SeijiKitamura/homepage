<?php
//---------------------------------------------------//
// デバックモード(true で「する」、falseで「しない」 //
//---------------------------------------------------//
define("DEBUG",true);
//---------------------------------------------------//


//---------------------------------------------------//
// Web系ディレクトリ系定数
//---------------------------------------------------//
define("HOME","hp/");             //ルートディレクトリ
define("IMG" ,HOME."img/");             //画像ディレクトリ
define("JS"  ,HOME."js/");              //JavaScript Jquery保存場所
define("PHP" ,HOME."php/");             //PHP
define("CSS" ,HOME."css/");             //CSS

//---------------------------------------------------//
// ファイル系定数(Web用)
//---------------------------------------------------//
define("FAV"     ,IMG."kitamura.ico");   //ファビコン
define("LOGO"    ,IMG."logo2.jpg");      //ロゴ
define("JQ"      ,JS."jquery.js");       //jQueryファイル名
define("CSSPATH" ,CSS."kitamura.css");   //CSSファイル名

//---------------------------------------------------//
// リンク系配列(ページ最上段に表示するリンク)
//---------------------------------------------------//
$PAGELINK1=array( array("url"  =>"about.html",
                        "local"=>"会社概要"
                       )
                 ,array("url"  =>"access.html",
                        "local"=>"アクセス"
                       )
                 ,array("url"  =>"",
                        "local"=>"求人"
                       )
                 ,array("url"  =>"sinsotu.html",
                        "local"=>"新卒採用"
                       )
                 );

//---------------------------------------------------//
// リンク系配列(ページ上段に表示するリンク)
//---------------------------------------------------//
$PAGELINK2=array( 
            array("url"  =>"index.php",
                  "local"=>"ホーム"
                 )
           ,array("url"  =>"tirasiitem.php",
                  "local"=>"今週のチラシ"
                 )
           ,array("url"  =>"item.php",
                  "local"=>"商品のご案内"
                 )
           ,array("url"  =>"mailitem.php",
                  "local"=>"メール商品"
                 )
           ,array("url"  =>"calendar.php",
                  "local"=>"カレンダー"
                 )
                );
//---------------------------------------------------//
// ファイルディレクトリ系定数(cron用)
//---------------------------------------------------//
define("SITEDIR","/var/www/");  //このサイトのトップディレクトリ
define("IMGDIR" ,SITEDIR.IMG);  //画像保存場所
define("JSDIR"  ,SITEDIR.JS);   //JavaScript Jquery保存場所
define("PHPDIR" ,SITEDIR.PHP);  //PHP
define("CSSDIR" ,SITEDIR.CSS);  //css
//define("IMGDIR" ,SITEDIR."img/");  //画像保存場所
//define("JSDIR"  ,SITEDIR."js/");   //JavaScript Jquery保存場所
//define("PHPDIR" ,SITEDIR."php/");  //PHP
//define("CSSDIR" ,SITEDIR."css/");  //css
define("DATADIR",PHPDIR."data/"); //更新データ
define("LOGDIR" ,DATADIR."log/"); //ログデータ
//---------------------------------------------------//

//----------------------------------------------------------//
// ファイル名定数(これがそのままテーブル名となる)
//----------------------------------------------------------//
define("CAL"      ,"calendar");          //カレンダー
define("TITLES"   ,"tirasititle");       //チラシタイトル(削除予定)
define("ITEMS"    ,"tirasiitem");        //チラシデータ
define("JANMAS"   ,"janmas");            //単品マスタ
define("CLSMAS"   ,"clsmas");            //クラスマスタ
define("LINMAS"   ,"linmas");            //部門マスタ
define("RESERVE"  ,"reserve");           //ご予約商品マスタ
define("USER"     ,"usermas");           //ご客様マスタ
define("MAILLIST" ,"maillist");          //メール(削除予定)
define("MAILITEMS","mailitems");         //メールアイテム
define("SALEITEMS","saleitems");         //アイテム
define("PAGECONF" ,"pageconfig");        //ページごとの設定
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
define("MAILITEMSCSV",DATADIR.MAILITEMS.".csv");//メールアイテム
define("PAGECONFCSV",DATADIR.PAGECONF.".csv");  //ページごとの設定
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
define("TB_TITLES"      ,TABLE_PREFIX.TITLES);    //チラシタイトル(削除予定)
define("TB_ITEMS"       ,TABLE_PREFIX.ITEMS);     //チラシデータ
define("TB_JANMAS"      ,TABLE_PREFIX.JANMAS);    //単品マスタ
define("TB_CLSMAS"      ,TABLE_PREFIX.CLSMAS);    //クラスマスタ
define("TB_LINMAS"      ,TABLE_PREFIX.LINMAS);    //部門マスタ
define("TB_RESERVE"     ,TABLE_PREFIX.RESERVE);   //ご予約
define("TB_USER"        ,TABLE_PREFIX.USER);      //お客様マスタ
define("TB_MAILLIST"    ,TABLE_PREFIX.MAILLIST);  //メール(削除予定)
define("TB_MAILITEMS"   ,TABLE_PREFIX.MAILITEMS); //メール(削除予定）
define("TB_SALEITEMS"   ,TABLE_PREFIX.SALEITEMS); //アイテム
define("TB_PAGECONF"    ,TABLE_PREFIX.PAGECONF);  //ページ設定

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
                              "flg0"     =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>1
                                                 ,"local"  =>"チラシ番号"
                                                )//flg0
                             ,"saleday"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"投函日"
                                                )//saleday   
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saleday   
                             ,"sname"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"タイトル"
                                                )//sname    
                             ,"notice"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice  
                            ,"flg1"      =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"開始日"
                                                )//flg1
                            ,"flg2"      =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"終了日"
                                                )//flg2  
                            )//TB_TITLES
            ,TB_ITEMS=>array(
                              "id"       =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>"auto"
                                                 ,"default"=>"0"
                                                 ,"primary"=>1
                                                 ,"local"  =>"番号"
                                                )//id
                             ,"flg0"     =>array( "type"   =>"int"
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
                             ,"flg1"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"サブタイトル"
                                                )//flg1
                             ,"saleday"  =>array( "type"   =>"date"
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
                             ,"price"    =>array( "type"   =>"varchar(255)"
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
                            ,"flg2"      =>array( "type"   =>"int"
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
                             ,"saleday"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"日付"
                                                )//saleday 
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"idxnum" =>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saletype
                             ,"sname"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"タイトル"
                                                )//title    
                             ,"price"    =>array( "type"   =>"varchar(255)"
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
                                              )//clscode
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
                             ,"saleday"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売日"
                                                )//saleday   
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saletype  
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
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
                             ,"maker"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                               ,"sname"=>array(   "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"商品名"
                                                 )//sname   
                             ,"tani"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                             ,"flg0"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"通常売価"
                                                )//baika   
                             ,"price"    =>array( "type"   =>"varchar(255)"
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
              ,TB_SALEITEMS=>array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id
                             ,"saleday"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売日"
                                                )//saleday   
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saletype  
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
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
                             ,"maker"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                              ,"sname"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"商品名"
                                                 )//sname   
                             ,"tani"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                             ,"price"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"売価"
                                                )//price   
                             ,"notice"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice  
                             ,"flg0"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ0"
                                                )//flg0  
                             ,"flg1"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ1"
                                                )//flg1  
                             ,"flg2"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ2"
                                                )//flg2  
                                  )//TB_SALEITEMS
              ,TB_PAGECONF=>array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id
                             ,"pagename" =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"ページ名"
                                                )//pagename  
                             ,"attr"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"属性"
                                                )//attr  
                             ,"val"      =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"値"
                                                )//val
                                  )//TB_PAGECONF
            );//TABLES

//---------------------------------------------------//

//---------------------------------------------------//
// CSV並び順配列
//---------------------------------------------------//
$CSVCOLUMNS=array(   CAL   =>array( "saleday"
                                    ,"saletype"
                                    ,"sname"
                                    ,"price"
                                    ,"notice"
                                    ,"clscode"
                                   )//TB_CAL
               ,MAILITEMS   =>array( "saleday"
                                    ,"saletype"
                                    ,"clscode"
                                    ,"jcode"
                                    ,"maker"
                                    ,"sname"
                                    ,"tani"
                                    ,"flg0"
                                    ,"price"
                                    ,"notice"
                                   )//MAILITEMS
                     ,TITLES=>array( "flg0"
                                    ,"saleday"
                                    ,"saletype"
                                    ,"sname"
                                    ,"notice"
                                    ,"flg1"
                                    ,"flg2"
                                   )//TB_TITLES
                     ,ITEMS =>array( "flg0" //tirasi_id
                                    ,"saleday"
                                    ,"saletype"
                                    ,"clscode"
                                    ,"jcode"
                                    ,"maker"
                                    ,"sname"
                                    ,"tani"
                                    ,"price"
                                    ,"notice"
                                    ,"flg1" //subtitle
                                    ,"flg2" //specialflg
                                   )//TB_ITEMS
                  ,TB_JANMAS=>array( //後日、JANMASに変更すること！
                                     "jcode"
                                    ,"clscode"
                                    ,"sname"
                                    ,"stdprice"
                                    ,"price"
                                    ,"lastsale"
                                   )//TB_JANMAS
                  ,TB_CLSMAS=>array(//後日、CLSMASに変更すること！
                                     "clscode"
                                    ,"clsname"
                                    ,"lincode"
                                   )//TB_CLSMAS
                  ,TB_LINMAS=>array(//後日、LINMASに変更すること！
                                     "lincode"
                                    ,"linname"
                                    ,"dpscode"
                                   )//TB_LINMAS
                 ,TB_RESERVE=>array(//後日、RESERVEに変更すること！
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
                  ,PAGECONF=>array ( 
                                     "pagename"
                                    ,"attr"
                                    ,"val"
                                   )//PAGECONF
                 );//CSVCOLUMNS
//---------------------------------------------------//

//---------------------------------------------------//
// SALETYPE
//---------------------------------------------------//
$SALETYPE=array(
                 0=>"広告の品"
                ,1=>"メール商品"
                ,2=>"おすすめ品"
                ,3=>"カレンダー"
                ,4=>"早期ご予約"
                ,5=>"オードブル・お弁当注文"
                );
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

$MENSEKI=<<<EOF
免責:表示されている商品について
品切れ、メーカー欠品、スポット商品などにより店頭に在庫がなく販売できない場合もございます。
また、こちらに表示しております価格と店頭価格に差異があった場合、誠に恐れ入りますが店頭価格にて販売させていただきます。
EOF;

$KAISYAMEI=<<<EOF
株式会社　スーパーキタムラ<br />
営業時間:AM9:30 - PM 10:00 <br />
定休日:なし(年中無休)<br />
EOF;

//---------------------------------------------------//
// データ表示系定数                                  //
//---------------------------------------------------//
define("JANMASLIMIT",10);//1画面に表示させるアイテム数 
define("NAVISTART",5);   //ナビ表示開始ページ(現在ページより前ページ）
define("NAVISPAN",10);   //ナビ表示ページ数 
define("SALESTART",30); //新商品の抽出基準。本日より何日前までを新商品とするか
define("NEWITEM",20);  //新商品の表示件数。
?>
