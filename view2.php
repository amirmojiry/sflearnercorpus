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
<title>دیدن متن های قبلی</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body dir="rtl">
<?php include 'header.php';?>

-
<div align="center" width="100%" border="0">
<form method="post" action="insertdata.php">
<table align="center" width="70%" border="0">
<tr>
<td id="mustafa_header_right">
<label>نام کشور نویسنده متن</label>
<input type="text" name="nationality" placeholder="نام کشور نویسنده متن" autofocus required maxlength="50"/>
<label>سطح نویسنده</label>
<select name="level_text_id" required >
    <option value=""></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option
  </select>
</td>
<td id="mustafa_header_center">
<label>تایپ کننده</label>
<input type="text" name="typist" placeholder="تایپ کننده" maxlength="50"/>
<br>
<label>نوع متن</label>
<select id="type_text" name="type_text" required >
    <option value=""></option>
    <option value="3">آزمون نوشتار (انشاء)</option>
    <option value="4">آزمون گفتار (برداشت)</option>
    <option value="5">آزمون گفتار (گفتگو)</option>
  </select>
</td>
<td id="mustafa_header_left">
<label>نمره</label>
<input type="number" name="score" placeholder="نمره" required min="0" max="21" step="0.01" />
</td>
</tr>
</table>
<table align="center" width="70%" border="0">
<tr>
<td><button type="submit" name="btn-login">ثبت</button></td>
</tr>
</table>
</form>
</div>
<div>
<?php $q = "SELECT * FROM text WHERE Typist_ID=".$_SESSION['user']; 
$r = @mysql_query ($q); // اجرای پرسوجو
// شمارش تعداد دریافتی ها
$num = mysql_num_rows($r);
if ($num > 0) { // اگر دریافتی وجود داشت
      // چاپ تعداد متن ها
      echo "<p> شما تاکنون $num متن تایپ کرده اید. </p> ";
      echo '<div id="view">';
      // سربرگ جدول
      echo '<div id="table-header">
      <div class="table-header">موضوع متن</div>
      <div class="table-header">  نوع متن </div>
      <div class="table-header"> کشور نویسنده </div>
      <div class="table-header"> سطح نویسنده </div>
      <div class="table-header"> نمره </div>
      <div class="table-header"> تایپ کننده </div>
      </div>';
      // دریافت و چاپ همه رکوردها
      echo '<div id="table-record">';
      while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
                  echo '<div class="table-record">' . $row['Subject'] . '</div>' ;
                  $type_text_result=mysql_query("SELECT * FROM type_text WHERE Type_Text_ID=".$row['Type_Text_ID']);
                  $type_text=mysql_fetch_array($type_text_result);
                  echo '<div class="table-record">' . $type_text["Type_Text"] . '</div>' ;
                  echo '<div class="table-record">' . $row['Nationality'] . '</div>' ;
                  echo '<div class="table-record">' . $row['Level_Text_ID'] . '</div>' ;
                  echo '<div class="table-record">' . $row['Score'] . '</div>' ;
                  echo '<div class="table-record">' . $row['Typist_ID'] . '</div>' ;
      }
      echo '</div>'; // پایان رکوردها
      echo '</div>'; // پایان جدول
      mysql_free_result ($r); // آزادسازی منابع 
} else { // اگر رکوردی نبود
                  echo '<p class="error"> شما تاکنون متنی تایپ نکرده اید. </p>'; }
?>
<br><br></div>
<?php include 'footer.php';?>
</body>
</html>