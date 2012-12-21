<?php

//---------------------------------------------------//
// リンク系配列(ページ上段に表示するリンク)
//---------------------------------------------------//
$PAGELINK2=array( 
            array("url"  =>"index.php",
                  "local"=>"ホーム",
                  "css"=>"",
                  "next"=>"tirasiitem.php",
                  "prev"=>"",
                  "index"=>"index",
                  "follow"=>"nofollow",
                  "description"=>"東京都大田区南馬込の桜並木にある食品スーパーマーケットです。"
                  )
                 ,array("url"  =>"tirasiitem.php",
                        "local"=>"今週のチラシ",
                        "description"=>"今週のチラシをご案内中！",
                        "nextpage"=>"calendar.php"
                        "prevpage"=>"index.php",
                       )
                 ,array("url"  =>"calendar.php",
                        "local"=>"カレンダー",
                        "description"=>"日替わりで実施されるお得なカレンダー情報を掲載中。",
                        "nextpage"=>"calendar.php"
                        "prevpage"=>"index.php",
                       )
                 ,array("url"  =>"item.php",
                        "local"=>"商品のご案内",
                        "description"=>"現在の取扱商品をご案内。",
                        "nextpage"=>"mailitem.php"
                        "prevpage"=>"index.php",
                       )
                 ,array("url"  =>"mailitem.php",
                        "local"=>"メール商品",
                        "description"=>"本日のメール商品はこちらです。メール会員特別価格実施中です。",
                        "nextpage"=>""
                        "prevpage"=>"index.php",
                       )
                 );

?>
