<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $url = 'https://vnexpress.net/the-thao';
    $content = file_get_contents($url);
    echo $content;
?>