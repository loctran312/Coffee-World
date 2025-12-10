<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>lab 2_5</title>
</head>

<body>
<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
	include("lab2_5a.php");
	include("lab2_5b.php");
    include_once("lab2_5b.php");

	if(isset($x))
		echo "Giá trị của x là: $x";
	else
		echo "Biến x không tồn tại";

    echo "vi include_once neu da include vao thi khong them thuc hien include nua nen ket qua khac voi 4.6";
?>
</body>
</html>