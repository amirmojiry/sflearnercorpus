<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}

global $HOSTDB; // Host name
global $USERDB; // Mysql username
global $PASSDB; // Mysql password
global $NAMEDB;

$coo = mysqli_connect ( $HOSTDB, $USERDB, $PASSDB, $NAMEDB );
if (! $coo)
{
    die ( 'Could not connect: ' . mysqli_error ( $coo ) );
}
else
{
    if (! mysqli_connect_error ())
    {

        $coo->set_charset ( "utf8" );
        $result = mysqli_query ( $coo, "SET CHARACTER SET 'utf8';" );
        $result = mysqli_query ( $coo, "SET SESSION collation_connection = 'utf8_persian_ci';" );
		
    }
}


						
$query=mysqli_query($coo, "SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        آخرین تغییرات نرم افزار
    </title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Preloader Css -->
    <link href="plugins/material-design-preloader/md-preloader.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>
<body dir="rtl" class="theme-red">
<?php
include 'header.php';
include 'left_sidebar.php';
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                آخرین تغییرات نرم افزار
                <small>

                </small>
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-green">
                        <h2>
                            نسخه ی 3.0.2
                        </h2>
                        <small>
                            2 اسفند 1395 | 18:04
                        </small>
                    </div>
                    <div class="body">
                        <ul>
                            <li>
                                اضافه شدن بخش «هر نکته ی دستوری چند بار در پیکره هست؟» به «پروفایل مدیریتی»: اکنون مدیران سیستم میتوانند تعداد تکرار هر نکته ی دستوری در پیکره را ببینند.
                            </li>
                            <li>
همزمانی تغییر در متن برچسب خورده و متن: اکنون اگر برچسب های کادر «متن برچسب خورده» را پاک یا اصلاح کنید، همزمان با تغییر شما، «متن» رنگی هم تغییر می کند و دیگر نیاز نیست روی دکمه ی «اعمال ویرایش متن برچسب خورده» کلیک کنید.
                                <br>
                                نکته ی 1: این دکمه به خاطر اطمینان کاربران از ایجاد تغییرات خود، همچنان در نرم افزار وجود دارد.
                                <br>
                                نکته ی 2: برای حذف یک برچسب، باید بخش اول و آخر برچسب را حذف کنید. اگر ابتدا بخش اول را حذف کنید، متن رنگی شما به هم ریخته می شود اما با حذف بخش دوم، متن درست می شود.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-green">
                        <h2>
                            نسخه ی 3.0.1
                        </h2>
                        <small>
                            1 اسفند 1395 | 14:38
                        </small>
                    </div>
                    <div class="body">
                        <ul>
                            <li>
                                اضافه شدن دکمه ی تیک و ضربدر به جدول بخش «پروفایل»: این دکمه نشان دهنده ی وضعیت برچسب گذاری متن است. با کلیک روی این دکمه به صفحه ی برچسب گذاری شده وارد می شوید.
                            </li>
                            <li>
                                اضافه شدن بخش «پروفایل مدیریتی»: فقط مدیران سایت به این بخش دسترسی دارند و می توانند وضعیت برچسب گذاری متون همه ی کاربران را ببینند و برای هر متن به بخش دیدن، ویرایش و برچسب گذاری دسترسی یابند.
                            </li>
                            <li>
                                اضافه شدن بخش «آخرین تغییرات نرم افزار»: در این بخش تغییرات نسخه های مختلف نرم افزار قابل دیدن است.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jquery Core Js -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="plugins/node-waves/waves.js"></script>

<!-- Autosize Plugin Js -->
<script src="plugins/autosize/autosize.js"></script>

<!-- Moment Plugin Js -->
<script src="plugins/momentjs/moment.js"></script>

<!-- Jquery DataTable Plugin Js -->
<script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/pages/tables/jquery-datatable.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
</body>
</html>