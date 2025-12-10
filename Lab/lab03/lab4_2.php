<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $tong = 0;
    $i = 1;
    while($tong<=1000){
        $tong += $i;
        $i = $i + 1;
    }
    echo $i . " la n nho nhat de tong 1 + 2 + ... + n > 1000";
    echo "xai while";
?>