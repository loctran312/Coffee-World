<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $tong = 0;
    for($i=2;$i<=100;$i++) {
        if($i%2==0){
            $tong+=$i;
        }
    }
    echo $tong;
?>