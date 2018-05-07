<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$query=mysql_query("SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $userRow['First_Name']; ?> - خوش آمدی</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body dir="rtl">
<?php include 'header.php';?>

<div align="center" width="100%" border="0">
<form method="post" action="insertdata.php">
<table align="center" width="70%" border="0">
<tr><td>
<label>موضوع متن</label>
<input type="text" name="subject" placeholder="موضوع متن" required autofocus maxlength="50"/>
</td></tr>
<tr><td>
<label>نام کشور نویسنده متن</label>
<input type="text" name="nationality" placeholder="نام کشور نویسنده متن" required maxlength="50"/>
</td></tr>
<tr><td>
<label>نوع متن را انتخاب کنید.</label>
<select name="type_text" required >
    <option value=""></option>
    <option value="3">آزمون نوشتار (انشاء)</option>
    <option value="4">آزمون گفتار (برداشت)</option>
    <option value="5">آزمون گفتار (گفتگو)</option>
  </select>
</td></tr>
<tr><td>
<label>سطح نویسنده (شماره کتاب) را انتخاب کنید</label>
<select name="level_text_id" required >
    <option value=""></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">نامشخص</option>
  </select>
</td></tr>
</tr>
<tr><td>
<label>نمره</label>
<input type="number" name="score" placeholder="نمره" required min="0" max="20" step="0.01"/>
</td></tr>
<tr><td>
<label>متن</label>
<textarea name="text" rows="20" cols="30" required ></textarea>
</td></tr>
<tr>
<td><button type="submit" name="btn-login">ثبت</button></td>
</tr>
</table>
</form>
</div>
<?php include 'footer.php';?>
</body>
</html>