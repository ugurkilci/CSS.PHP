<?php

/*
 * Author: Uğur KILCI
 * 1.4.22 17:45
 * Tayfun Erbilen'in paylaştığı bir tweetten ilham alınarak yapılmıştır.
 * https://twitter.com/tayfunerbilen/status/1509811470812561409 
 */

// Başka sayfalarda kullanabilmek için PHP kodunu CSS olarak tanıtıyorum.
header("Content-Type: text/css");

// İki kelime arasındaki veriyi almak için kullanılan fonksiyondur.
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

// CSS dosyanın konumu
$CSS = @$_GET["q"];

// CSS dosyasını açıyoruz
$file = fopen($CSS, 'r');
$content = fread($file, filesize($CSS));
fclose($file);

// Dosya içinde bulunan "percent" koduna özellik atıyoruz.
// percent(#000, 60%); bu kodun önce parantez içindekileri alıp sonra "," virgül ile parçalıyoruz.
// Elimde 2 veri var. 1. renk kodu ve 2. şeffaflık yüzdesi.
$percent =
explode(
    ",",
    get_string_between(
        $content,
        "percent(", ")"
    )
);

// $replace içinde dönüşecek yeni kodu yazıyorum.
// Kod içinde yüzdeyi 100'e bölüyorum. Bu sayede 0 ile 1 arasında bir değere ulaşabilirim. 
$replace = $percent[0] . ";opacity:" . rtrim($percent[1], "%") / 100;

// Değiş tokuş yapabilmek için eski kodu oluşturmam lazım.
$old = "percent(" . $percent[0] . "," . $percent[1] . ")";

// Şimdi tüm kod içerisinde eski kod ile yeni kodu taratıp değiş tokuş yapıyorum.
echo str_replace(
    $old, $replace, $content
);

// Kod burada. CSS'e ekstra özellikler eklenebilir. Geliştirilebilir.