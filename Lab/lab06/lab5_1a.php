<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $url = 'https://stu.edu.vn/';

    $html = file_get_contents($url);

    if ($html === false) {
        echo "Không tải được trang . $url <br>";
    } else {
        echo "Tải trang thành công. $url <br>";
    }

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);

    $links = $doc->getElementsByTagName('a');

    $count = 0;
    $maxLinks = 30;
    foreach ($links as $link) {
        if ($link instanceof DOMElement) {
            echo $link->getAttribute('href') . "<br>";
        }
        $count++;
        if ($count >= $maxLinks) {
            break;
        }
    }
?>