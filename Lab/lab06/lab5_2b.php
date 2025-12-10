<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $url = 'http://dantri.com.vn/';
    $html = file_get_contents($url);

    if ($html === false) {
        echo "Không thể tải nội dung trang. $url <br>";
    } else {
        echo "Tải thành công trang $url. <br>";
    }

    $email_pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/';

    $phone_pattern = '/(\+?[0-9]{1,4}[ -]?)?(\(?\d{3}\)?[ -]?)?\d{3}[ -]?\d{4}/';

    preg_match_all($email_pattern, $html, $emails);

    preg_match_all($phone_pattern, $html, $phones);

    echo "Emails:\n";
    echo "<pre>";
    var_dump($emails[0]);
    echo "</pre>";

    $count = 0;
    $maxLinks = 20;

    echo "\nPhones:\n <br>";

    foreach ($phones[0] as $phone) {
        echo $count + 1 . ': ' . $phone . "<br>";
        $count++;
        if ($count >= $maxLinks) {
            break;
        }
    }
?>