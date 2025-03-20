<?php

require_once __DIR__."/config.php";

/**
  *
  */

function h($value){
    return !empty($value) ? htmlspecialchars($value, ENT_QUOTES, "utf-8") : "";
}

function randomString(){

    $tmp = "";
    $inputString = "abcdefghijklmnopqrstuvwxyz0123456789";

    for( $i=0; $i < 10; $i++ ){
        $randIndex = rand(0, 35);
        $tmp .= $inputString[$randIndex];
    }

    return $tmp;
}

function prefectureArr(){
    return $prefectures = [1 => "北海道",
                           2 => "青森県",
                           3 => "岩手県",
                           4 => "宮城県",
                           5 => "秋田県",
                           6 => "山形県",
                           7 => "福島県",
                           8 => "茨城県",
                           9 => "栃木県",
                           10 => "群馬県",
                           11 => "埼玉県",
                           12 => "千葉県",
                           13 => "東京都",
                           14 => "神奈川県",
                           15 => "新潟県",
                           16 => "富山県",
                           17 => "石川県",
                           18 => "福井県",
                           19 => "山梨県",
                           20 => "長野県",
                           21 => "岐阜県",
                           22 => "静岡県",
                           23 => "愛知県",
                           24 => "三重県",
                           25 => "滋賀県",
                           26 => "京都府",
                           27 => "大阪府",
                           28 => "兵庫県",
                           29 => "奈良県",
                           30 => "和歌山県",
                           31 => "鳥取県",
                           32 => "島根県",
                           33 => "岡山県",
                           34 => "広島県",
                           35 => "山口県",
                           36 => "徳島県",
                           37 => "香川県",
                           38 => "愛媛県",
                           39 => "高知県",
                           40 => "福岡県",
                           41 => "佐賀県",
                           42 => "長崎県",
                           43 => "熊本県",
                           44 => "大分県",
                           45 => "宮崎県",
                           46 => "鹿児島県",
                           47 => "沖縄県"];
}

function areaPrefecture($value){

    $prefectures = prefectureArr();

    foreach($prefectures as $k => $pref){
        if( $pref === $value ){
            if( $k === 1 ){
              return "北海道";
            } elseif( 2 <= $k && 7>= $k ){
              return "東北";
            } elseif( 8 <= $k && 14 >= $k ){
              return "関東";
            } elseif( 15 <= $k && 18 >= $k ){
              return "北陸";
            } elseif( 19 <= $k && 23 >= $k ){
              return "東海";
            } elseif( 24 <= $k && 30 >= $k ){
              return "関西";
            } elseif( 31 <= $k && 35 >= $k ){
              return "中国";
            } elseif( 36 <= $k && 39 >= $k ){
              return "四国";
            } elseif( 30 <= $k && 47 >= $k ){
              return "九州";
            } else {
              return "不明";
            }
        }
    }

}


?>