<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
    ?>
    <form>
        nhap a: <input type="number" name="a"> <br>
        nhap b: <input type="number" name="b"> <br>
        <input type="submit" value="tinh">
    </form>
    <?php
        if(isset($_GET['a']) && isset($_GET['b'])) {
            $a=(int)$_GET['a'];
            $b=(int)$_GET['b'];
        }
        if($b == 0) {
            echo "b = 0 khong chia duoc";
        } else {
            echo "phan nguyen cua a/b: " . intdiv($a,$b);
            echo "<br>";
            echo "phan du cua a/b: " . $a%$b;
        }
    ?>
</body>
</html>