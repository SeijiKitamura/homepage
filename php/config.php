<?php
//---------------------------------------------------//
// デバックモード(true で「する」、falseで「しない」 //
//---------------------------------------------------//
define("DEBUG",true);
//---------------------------------------------------//

define("HOME","/hp/");             //ルートディレクトリ
define("SITEDIR","/var/www");  //保存場所(cron用)
//define("SITEDIR","/home/kitamura/public_html"); //保存場所(cron用)

define("DBHOST"  ,"172.16.0.13");  //サーバー名
define("DBNAME"  ,"homepage");     //データベース名
define("DBUSER"  ,"kennpin1");     //DBユーザー名
//define("DBHOST"  ,"localhost");  //サーバー名
//define("DBNAME"  ,"kitamura_homepage");     //データベース名
//define("DBUSER"  ,"kitamura_mysql");     //DBユーザー名
define("DBPASS"  ,"1");            //DBパスワード
define("TABLE_PREFIX"   ,"he_");   //テーブルプレフィックス

define("LOGONAME","logo2.jpg");          //ロゴファイル名
define("LOGOMSG" ,"スーパーキタムラ");   //ロゴメッセージ
define("FAVNAME" ,"kitamura.ico");       //ファビコンファイル名
define("JQNAME"  ,"jquery.js");          //jQueryファイル名


define("JANMASLIMIT",10);//1画面に表示させるアイテム数 
define("NAVISTART",5);   //ナビ表示開始ページ(現在ページより前ページ）
define("NAVISPAN",10);   //ナビ表示ページ数 
define("SALESTART",30); //新商品の抽出基準。本日より何日前までを新商品とするか
define("NEWITEM",20);  //新商品の表示件数。

define("PAGETITLE",2); //改ページ挿入位置。1ページに印刷するサブタイトル数
define("PAGEITEM",13); //改ページ挿入位置。1ページに印刷するアイテム数
//---------------------------------------------------//
// SALETYPE
//---------------------------------------------------//
$SALETYPE=array(
                 0=>"広告の品"
                ,1=>"メール商品"
                ,2=>"おすすめ品"
                ,3=>"カレンダー"
                ,4=>"早期ご予約"
                ,5=>"お弁当注文"
                );

$MENSEKI=<<<EOF
免責:表示されている商品について
品切れ、メーカー欠品、スポット商品などにより店頭に在庫がなく販売できない場合もございます。
また、こちらに表示しております価格と店頭価格に差異があった場合、誠に恐れ入りますが店頭価格にて販売させていただきます。
EOF;

$MENSEKI2=<<<EOF
<ul>
<li>掲載しております写真は一例となっております。お弁当に入っている青物、漬物、煮物につきましては変更となる場合がございます。</li>
<li>お買上金額合計3000円以上で配達送料無料となります。</li>
<li>当日、午前10時40分までにご注文くださいませ。</li>
</ul>
EOF;

$KAISYAMEI=<<<EOF
株式会社　スーパーキタムラ<br />
営業時間:AM9:30 - PM 10:00 <br />
定休日:なし(年中無休)<br />
EOF;

//---------------------------------------------------//
// Web系ディレクトリ系定数
//---------------------------------------------------//
define("IMG" ,HOME."img/");             //画像ディレクトリ
define("JS"  ,HOME."js/");              //JavaScript Jquery保存場所
define("PHP" ,HOME."php/");             //PHP
define("CSS" ,HOME."css/");             //CSS

//---------------------------------------------------//
// ファイル系定数(Web用)
//---------------------------------------------------//
define("FAV"     ,IMG.FAVNAME);       //ファビコン
define("LOGO"    ,IMG.LOGONAME);      //ロゴ
define("JQ"      ,JS.JQNAME);         //jQueryファイル名

//---------------------------------------------------//
// ファイルディレクトリ系定数(cron用)
//---------------------------------------------------//
define("IMGDIR" ,SITEDIR.IMG);  //画像保存場所
define("JSDIR"  ,SITEDIR.JS);   //JavaScript Jquery保存場所
define("PHPDIR" ,SITEDIR.PHP);  //PHP
define("CSSDIR" ,SITEDIR.CSS);  //css
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
define("RESERVE"  ,"reserve");           //ご予約商品マスタ(削除予定)
define("USER"     ,"usermas");           //ご客様マスタ
define("MAILLIST" ,"maillist");          //メール(削除予定)
define("MAILITEMS","mailitems");         //メールアイテム
define("GOYOYAKU" ,"goyoyaku");          //ご注文商品
define("SALEITEMS","saleitems");         //アイテム
define("PAGECONF" ,"pageconfig");        //ページごとの設定
//---------------------------------------------------//

//---------------------------------------------------//
// ファイルパス系定数
//---------------------------------------------------//
define("CALCSV"     ,DATADIR.CAL.".csv");       //カレンダー
define("TITLECSV"   ,DATADIR.TITLES.".csv");    //チラシタイトル
define("ITEMCSV"    ,DATADIR.ITEMS.".csv");     //チラシデータ
define("JANCSV"     ,DATADIR.JANMAS.".csv");    //単品マスタ
define("CLSCSV"     ,DATADIR.CLSMAS.".csv");    //クラスマスタ
define("LINCSV"     ,DATADIR.LINMAS.".csv");    //部門マスタ
define("RESERVECSV" ,DATADIR.RESERVE.".csv");   //ご予約商品マスタ
define("MAILITEMSCSV",DATADIR.MAILITEMS.".csv");//メールアイテム
define("GOYOYAKUCSV",DATADIR.GOYOYAKU.".csv");  //ご予約商品
define("PAGECONFCSV",DATADIR.PAGECONF.".csv");  //ページごとの設定
//---------------------------------------------------//


//---------------------------------------------------//
// DB 接続系定数
//---------------------------------------------------//

//---------------------------------------------------//
// DB テーブル名定数
//---------------------------------------------------//
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

$TABLES=array(
               TB_JANMAS=>array(
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
$CSVCOLUMNS=array(   CAL   =>array(  "saleday"
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
                  ,JANMAS   =>array(
                                     "jcode"
                                    ,"clscode"
                                    ,"sname"
                                    ,"stdprice"
                                    ,"price"
                                    ,"salestart"
                                    ,"lastsale"
                                   )//JANMAS
                  ,CLSMAS   =>array(
                                     "clscode"
                                    ,"clsname"
                                    ,"lincode"
                                   )//CLSMAS
                  ,LINMAS   =>array(
                                     "lincode"
                                    ,"linname"
                                    ,"dpscode"
                                   )//LINMAS
                  ,GOYOYAKU=>array (
                                     "saletype"
                                    ,"saleday"
                                    ,"flg0"      //グループ番号
                                    ,"flg1"      //グループ名
                                    ,"flg2"      //表示番号
                                    ,"clscode"
                                    ,"jcode"
                                    ,"maker"
                                    ,"sname"
                                    ,"tani"
                                    ,"price"
                                    ,"notice"
                                   )//GOYOYAKU
                  ,PAGECONF=>array ( 
                                     "pagename"
                                    ,"attr"
                                    ,"val"
                                   )//PAGECONF
                 );//CSVCOLUMNS
//---------------------------------------------------//

?>
