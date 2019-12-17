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
		
		//query for texts
		$query = "SELECT * FROM text WHERE Typist_ID=".$_SESSION['user'];
        $result = mysqli_query ( $coo, $query );

        if ($result)
        {
            if ($result->num_rows > 0)
            {
				$number = 0;
				$AllTexts = array ();
                while ( $mrow = mysqli_fetch_assoc ( $result ) )
                {
                    $AllTexts [$number] = $mrow;
					$number++;
                }
            }
        }
    }
}

$query=mysql_query("SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> آمار کاربران </title>
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
    <link href=".plugins/node-waves/waves.css" rel="stylesheet" />

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
</head>
<body dir="rtl" class="theme-red">
<?php include 'header.php';?>
<?php include 'left_sidebar.php'; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
آمار کاربران
                <small>
                    <?php
                    $all_text_count_query = mysql_query("SELECT * FROM text");
                    $all_text_rows = mysql_num_rows($all_text_count_query);
                    $your_text_count_query = mysql_query("SELECT * FROM text WHERE Typist_ID=".$userRow['User_ID']);
                    $your_text_rows = mysql_num_rows($your_text_count_query);
                    echo "کل متن های شما: ".
                        $your_text_rows;
                    echo "| کل متن های واردشده: ".
                        $all_text_rows;
                    ?>
                </small>
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
آمار کاربران
                            <small>
                                <?php
                                //Jalali Date
                                $day_number = jdate('j');
                                $month_number = jdate('n');
                                $year_number = jdate('y');
                                $day_name = jdate('l');
                                echo "امروز ";
                                echo "<td>$day_name ، $day_number-$month_number-$year_number"."</td></tr>";
                                echo "/ ساعت: ";
                                echo "<td>".date("h:i:sa")."</td></tr>";
                                ?>
                            </small>
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        $q = "SELECT * FROM user ORDER BY Last_Name ASC";
                        $r = @mysql_query ($q);
                        $num = mysql_num_rows($r);
                        ?>
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>
نام خانوادگی و نام
                                </th>
                                <th>
نام کاربری
                                </th>
                                <th>
ایمیل
                                </th>
                                <th>
کد اختصاصی کاربر
                                </th>
                                <th>
تعداد متن تایپ شده
                                </th>
                                <th>
                                    جنسیت
                                </th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>
                                    نام خانوادگی و نام
                                </th>
                                <th>
                                    نام کاربری
                                </th>
                                <th>
                                    ایمیل
                                </th>
                                <th>
                                    کد اختصاصی کاربر
                                </th>
                                <th>
                                    تعداد متن تایپ شده
                                </th>
                                <th>
                                    جنسیت
                                </th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            if ($num > 0) {
                                while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
                                    echo '<tr>';
                                    echo '<td>' .$row['Last_Name'].' '.$row['First_Name'] . '</td>';
                                    echo '<td>' . $row['Username'] . '</td>';
                                    echo '<td>' . $row['Email'] . '</td>';
                                    echo '<td>' . $row['User_Code'] . '</td>';
                                    $text_count_query_one= mysql_query("SELECT * FROM text WHERE Typist_ID =".$row['User_ID']);
                                    $text_rows_one = mysql_num_rows($text_count_query_one);
                                    $one_text_rows_percentage = ($text_rows_one / 200)*100;
                                    $o_p = round($one_text_rows_percentage,2);
                                    $print_one_percentage_color="style='background-image: linear-gradient(right, #03f1fa
                                    $o_p%, transparent 0%); background-image: -webkit-linear-gradient(right, #03f1fa $o_p%,
                                    transparent 0%); background-image: -o-linear-gradient(right, #03f1fa $o_p%,
                                    transparent 0%); background-image: -moz-linear-gradient(right, #03f1fa $o_p%,
                                    transparent 0%);'";
                                    echo '<td '.$print_one_percentage_color.'>' . $text_rows_one . '</td>';
                                    if ($row['Gender'] == 0){
                                        $gender = "مرد";
                                    }
                                    else{
                                        $gender = "زن";
                                    }
                                    echo '<td>' . $gender . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                            </tbody>
                        </table>
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