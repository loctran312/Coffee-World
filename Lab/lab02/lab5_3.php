<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    $a = 2;
    $b = 5;
    $c = 3;
    echo $a . "x^2 +  " . $b . "x + " . $c;
    $delta = $b*$b - 4*$a*$c;
    if($delta < 0) {
        echo "pt vn";
    } elseif($delta == 0) {
        $x = -$b/(2*$a);
    } else {
        $x1 = (-$b+sqrt($delta))/ (2*$a);
        $x2 = (-$b-sqrt($delta))/ (2*$a);
        echo "<br>" . " ket qua: " . $x1 . " va " . $x2;
    }
?>