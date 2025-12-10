<?php
echo"<H1>Trần Hữu Lộc - DH52201004 - D22_TH07</H1>";
// Hàm lấy dữ liệu từ form POST
function postIndex($index, $value = "")
{
  // Nếu biến $_POST[$index] chưa tồn tại thì trả về giá trị mặc định $value
  if (!isset($_POST[$index])) return $value;
  // Nếu có thì trả về dữ liệu sau khi loại bỏ khoảng trắng thừa
  return trim($_POST[$index]);
}

// Hàm kiểm tra tính hợp lệ của username
function checkUserName($string)
{
  // Biểu thức chính quy cho phép: chữ cái a-z, A-Z, số 0-9, ký tự ., _ và -
  if (preg_match("/^[a-zA-Z0-9._-]*$/", $string))
    return true; // Nếu khớp thì hợp lệ
  return false;   // Nếu không khớp thì không hợp lệ
}

// Hàm kiểm tra định dạng email
function checkEmail($string)
{
  // echo $string; // In ra email để kiểm tra (debug)
  // Biểu thức chính quy kiểm tra email: phần trước @, tên miền, và phần mở rộng
  if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $string))
    return true;  // Email hợp lệ
  return false;  // Email không hợp lệ
}

// Hàm kiểm tra mật khẩu
function checkPassword($string)
{
  // Ít nhất 8 ký tự, có số, có chữ hoa, có chữ thường
  if (preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $string))
    return true;
  return false;
}

// Hàm kiểm tra số điện thoại
function checkPhone($string)
{
  if (preg_match("/^[0-9]{9,10}$/", $string))
    return true;
  return false;
}

// Hàm kiểm tra ngày sinh
function checkDateFormat($string)
{
  if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[-\/](0[1-9]|1[0-2])[-\/](\d{4})$/", $string))
    return true;
  return false;
}

// Lấy dữ liệu từ form
$sm = postIndex("submit");     // Nút submit
$username = postIndex("username"); // Username nhập vào
$email = postIndex("email");       // Email nhập vào
$password = postIndex("password");
$date = postIndex("date");
$phone = postIndex("phone");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ...>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Lab6_3</title>
  <style>
    /* Định dạng khung form */
    fieldset {
      width: 50%;
      margin: 100px auto;
    }

    .info {
      width: 600px;
      color: #006;
      background: #6FC;
      margin: 0 auto
    }

    #frm1 input {
      width: 300px
    }
  </style>
</head>

<body>
  <fieldset>
    <legend style="margin:0 auto">Đăng ký thông tin </legend>
    <!-- Form gửi dữ liệu bằng phương thức POST -->
    <form action="lab06_3.php" method="post" enctype="multipart/form-data" id='frm1'>
      <table align="center">
        <tr>
          <td width="88">UserName</td>
          <td width="317"><input type="text" name="username" value="<?php echo $username; ?>" />*</td>
        </tr>
        <tr>
          <td>Mật khẩu</td>
          <td><input type="text" name="password" />*</td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />*</td>
        </tr>
        <tr>
          <td>Ngày sinh</td>
          <td><input type="text" name="date" />*</td>
        </tr>
        <tr>
          <td>Điện thoại</td>
          <td><input type="text" name="phone" /></td>
        </tr>

        <tr>
          <td colspan="2" align="center">
            <input type="submit" value="submit" name="submit">
          </td>
        </tr>
      </table>
    </form>
  </fieldset>

  <?php
  // Nếu submit
  if ($sm != "") {
    $error = "";
  
    if (checkUserName($username) == false)
      $error .= "Username không hợp lệ<br>";
  
    if (checkEmail($email) == false)
      $error .= "Email không hợp lệ<br>";
  
    if (checkPassword($password) == false)
      $error .= "Mật khẩu phải >=8 ký tự, có ít nhất 1 số, 1 chữ hoa, 1 chữ thường<br>";
  
    if (checkPhone($phone) == false)
      $error .= "Số điện thoại chỉ được nhập số 10 ký tự<br>";
  
    if (checkDateFormat($date) == false)
      $error .= "Ngày sinh phải có định dạng dd/mm/yyyy hoặc dd-mm-yyyy<br>";
  
    if ($error != "") {
      echo "<div class='info'>Lỗi<br>$error</div>";
    } else {
      echo "<div class='info'>Dữ liệu hợp lệ!<br>";
      echo "Username: $username<br>";
      echo "Email: $email<br>";
      echo "Ngày sinh: $date<br>";
      echo "Điện thoại: $phone<br>";
      echo "</div>";
    }
  }
  
  ?>

    </div>
  <?php
  ?>
</body>

</html>