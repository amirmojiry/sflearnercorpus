<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}

$query=mysql_query("SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($query);

if(count($_POST)>0) {
    $result = mysql_query("SELECT * from user WHERE User_ID='" . $userRow["User_ID"] . "'");
    $row=mysql_fetch_array($result);
    if($_POST["currentPassword"] == $userRow["Password"]) {
        mysql_query("UPDATE user set Password='" . $_POST["newPassword"] . "' WHERE User_ID='" . $userRow["User_ID"] . "'");
        $message = "گذرواژه ی شما تغییر کرد.";
        $messageType= 'bg-green';
    } else {
        $message = "گذرواژه ی فعلی را اشتباه وارد کردید.";
        $messageType= 'bg-red';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>تغییر گذرواژه</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

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
    <?php
    header('Content-Type: text/html; charset=utf-8');
    //include jalali date and iran time
    include ('jdf.php');
    date_default_timezone_set ('Asia/Tehran');
    ?>
    <script>
        function validatePassword() {
            var currentPassword,newPassword,confirmPassword,output = true;

            currentPassword = document.frmChange.currentPassword;
            newPassword = document.frmChange.newPassword;
            confirmPassword = document.frmChange.confirmPassword;

            if(!currentPassword.value) {
                currentPassword.focus();
                document.getElementById("currentPassword").innerHTML = "پر کردن این بخش لازم است.";
                output = false;
            }
            else if(!newPassword.value) {
                newPassword.focus();
                document.getElementById("newPassword").innerHTML = "پر کردن این بخش لازم است.";
                output = false;
            }
            else if(!confirmPassword.value) {
                confirmPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "پر کردن این بخش لازم است.";
                output = false;
            }
            if(newPassword.value != confirmPassword.value) {
                newPassword.value="";
                confirmPassword.value="";
                newPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "گذرواژه ها یکسان نیستند.";
                output = false;
            }
            return output;
        }
    </script>
</head>

<body dir="rtl" class="theme-red">
<?php
include 'header.php';
include 'left_sidebar.php'; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
تغییر گذرواژه
            </h2>
            <?php
            if(isset($message)) {
                echo '<div class="alert '.$messageType.' alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="message">'.$message.'</div>';
            }
            ?>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            تغییر گذرواژه
                            <small>
                                گذرواژه ی جدید حداقل باید پنج کاراکتری باشد.
                            </small>
                        </h2>
                    </div>
                    <div class="body">
                        <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            گذرواژه ی فعلی
                                        </small>
                                        <span id="currentPassword" class="required col-pink"></span>
                                        <input type="password" name="currentPassword" class="form-control txtField"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            گذرواژه ی جدید
                                        </small>
                                        <span id="newPassword" class="required col-pink"></span>
                                        <input type="password" name="newPassword" class="form-control txtField"
                                               pattern=".{5,}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            تکرار گذرواژه ی جدید
                                        </small>
                                        <span id="confirmPassword" class="required col-pink"></span>
                                        <input type="password" name="confirmPassword" class="form-control txtField"
                                               pattern=".{5,}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" name="submit"
                                        class="btn btn-block btn-lg bg-red waves-effect center-block btnSubmit">
                                    ثبت
                                </button>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </form>
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

<!-- Bootstrap Notify Plugin Js -->
<script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
</body>
</html>