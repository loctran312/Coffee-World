<?php
echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
$url = file_get_contents('http://vietnamnet.vn/');
$doc = new DOMDocument();

libxml_use_internal_errors(true);

$doc->loadHTML($url);

$images = $doc->getElementsByTagName('img');

$file_pattern = '/^[a-zA-Z0-9_-]+\.(jpg|jpeg|png|gif)$/';

$count = 0;
$maxCount = 20;
foreach ($images as $image) {
    $count++;
    /** @var DOMElement $image */

    $src = $image->getAttribute('src');

    $file_name = basename($src);

    if (preg_match($file_pattern, $file_name)) {
        echo "Hình ảnh hợp lệ: $file_name\n". "<br>";
    } else {
        echo "Hình ảnh không hợp lệ: $file_name\n". "<br>";
    }
    if($count>=$maxCount){
        break;
    }
}
?>