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

        //query for label types
        $query = "SELECT label_type FROM label_text GROUP BY label_type";
        $result = mysqli_query ($coo, $query);

        if ($result)
        {
            if ($result->num_rows > 0)
            {
                $label_types = [];
                while ($mrow = mysqli_fetch_assoc ($result))
                {
                    $label_types[] = $mrow["label_type"];
                }
            }
        }
    }
}


						
$query=mysqli_query($coo, "SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>پروفایل شما</title>
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
                پروفایل شما
                <small>
                    <?php $q = "SELECT * FROM text WHERE Typist_ID=".$_SESSION['user'];
                    $r = @mysqli_query ($coo,$q); // اجرای پرسوجو
                    // شمارش تعداد دریافتی ها
                    $num = mysqli_num_rows($r);
                    if ($num > 0) { // اگر دریافتی وجود داشت
                        // چاپ تعداد متن ها
                        echo " شما تاکنون $num متن تایپ کرده اید. ";
                    }
                    else { // اگر رکوردی نبود
                        echo ' شما تاکنون متنی تایپ نکرده اید.'; }
                    ?>
                </small>
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            پروفایل
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>
                                    موضوع متن
                                </th>
                                <th>
                                    نوع متن
                                </th>
                                <th>
                                    کشور نویسنده
                                </th>
                                <th>
                                    سطح نویسنده
                                </th>
                                <th>
                                    شماره متن
                                </th>
                                <th>
                                    برچسب گذاری شده؟
                                </th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>
                                    موضوع متن
                                </th>
                                <th>
                                    نوع متن
                                </th>
                                <th>
                                    کشور نویسنده
                                </th>
                                <th>
                                    سطح نویسنده
                                </th>
                                <th>
                                    شماره متن
                                </th>
                                <th>
                                    برچسب گذاری شده؟
                                </th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            if (isset($AllTexts)) {
                                for($i = 0; $i < count ( $AllTexts); $i ++) {
                                    $errors_safari_labeling_get = '&label_type=errors-safari';
                                    echo '<tr>';
                                    echo '<td>' .  $AllTexts [$i]['Subject'];
                                    foreach ($label_types as $label_type) {
                                        echo "<a href='labeling1textWithLabelType.php?ID={$AllTexts [$i]['Text_ID']}&label_type=$label_type'>[$label_type]</a>";
                                    }
                                    echo '<a href="viewtext.php?ID='. $AllTexts [$i]["Text_ID"].'" target="_blank" title="دیدن متن">
                                        [<i class="material-icons font-12">remove_red_eye</i>]</a>'
                                        . '<a href="edittext.php?ID='. $AllTexts [$i]["Text_ID"].'" target="_blank" title="ویرایش متن">
                                        [<i class="material-icons font-12">edit</i>]</a>'
                                        . '<a href="labeling1text.php?ID='. $AllTexts [$i]["Text_ID"].'" target="_blank" title="برچسب گذاری متن">
                                        [<i class="material-icons font-12">description</i>]</a>'
                                        . '<a href="labeling1textWithLabelType.php?ID='.$AllTexts [$i]["Text_ID"]
                                        .$errors_safari_labeling_get.'" title="برچسب زنی خطا بر اساس پژوهش سعید صفری">
                                        [<i class="material-icons font-12">error</i>]</a>'
                                    . '</td>';
                                    
                                    $type_text_result = mysqli_query($coo, "SELECT * FROM type_text WHERE Type_Text_ID=" .  $AllTexts [$i]['Type_Text_ID']);
                                    $type_text = mysqli_fetch_assoc($type_text_result);
                                    echo '<td>' . $type_text["Type_Text"] . '</td>';
                                    echo '<td>' .  $AllTexts [$i]['Nationality'] . '</td>';
                                    echo '<td>' .  $AllTexts [$i]['Level_Text_ID'] . '</td>';
                                    echo '<td>' . $userRow['User_Code'] . '-' .  $AllTexts [$i]["Text_ID"] . '</td>';
                                    echo '<td>';
                                    if ($AllTexts [$i]['LabeledText']==''){
                                        echo '<a href="labeling1text.php?ID='. $AllTexts [$i]["Text_ID"].'">
                                        <i class="material-icons" style="color:red">close</i></a>';
                                    } else {
                                        echo '<a href="labeling1text.php?ID='. $AllTexts [$i]["Text_ID"].'">
                                        <i class="material-icons" style="color:green">check</i></a>';
                                    }
                                    echo '</td>';
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