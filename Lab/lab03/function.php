<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
function tongHop() {
    $functions = ['BCC','BanCo'];
    $result="";
    foreach($functions as $value) {
        if(function_exists($value)) {
            $result.=$value()."";
        }
    }
    return trim($result);
}
    echo tongHop();
?>