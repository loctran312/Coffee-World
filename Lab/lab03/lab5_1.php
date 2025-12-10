<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
function kiemtranguyento($x)//Kiểm tra 1 số có nguyên tố hay không
{
	if($x<2)
		return false;
	if($x==2)
		return true;
    $i = 2;
    do {
		if($x%$i==0) {
			return false;
			break;
		}
		$i = $i + 1;
    }while($i<=sqrt($x));
	return true;
}
function xuatSoNguyenToDauTien($n){
    echo "$n Số nguyên tố đầu tiên: ";
    $dem = 0;
    $i=2;
    while ($dem<$n)
    {   
            if(kiemtranguyento($i)) {
                if($dem<$n)
                    echo $i . " ";
                $dem++;
            }
            $i++;
    
    }
}
xuatSoNguyenToDauTien(5);
?>