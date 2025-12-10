<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>lab 2_5</title>
</head>

<body>
<?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
	require("lab2_5a.php");
	require("lab2_5b.php");
    require("lab2_5b.php");

	if(isset($x))
		echo "Giá trị của x là: $x";
	else
		echo "Biến x không tồn tại";

    echo "ket qua khi thay include va require giong nhau";
?>
</body>
</html>