<?php
include 'corpus_config.php';
include_once 'persian_date.class.php';


global $HOSTDB; // Host name
global $USERDB; // Mysql username
global $PASSDB; // Mysql password
global $NAMEDB;

$arr = NULL;
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

        $query = "SELECT * FROM text";

        $result = mysqli_query ( $coo, $query );

        if ($result)
        {
            if ($result->num_rows > 0)
            {
                $cntr = 0;
                $AllTexts = array ();
                while ( $mrow = mysqli_fetch_assoc ( $result ) )
                {
                    $AllTexts [$cntr] = $mrow; // ['userTypeID'];
                    $cntr ++;
                }
            }
        }

    }
}
?>

<!DOCTYPE html>
<html>

<script>
    var modal_id = '';
</script>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        فهرست متن های تایپ شده در سامانه پیکره زبان آموز بنیاد سعدی (تا تاریخ 2 آذر 95)
    </title>
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

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper" dir="rtl">
    <div class="loader">
        <div class="md-preloader pl-size-md">
            <svg viewbox="0 0 75 75">
                <circle cx="37.5" cy="37.5" r="33.5" class="pl-red" stroke-width="4" />
            </svg>
        </div>
        <p>
            لطفا منتظر باشید...
        </p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="
        بنویسید...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <i class="material-icons">expand_more</i>
            </a>
            <a href="javascript:void(0);" class="bars"></a>
            <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#leftsidebar">
                <i class="material-icons">menu</i>
            </button> -->
            <a class="navbar-brand" href="index.php">
                سامانه جامع مرکز آموزش
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<?php
//Turn off Error reporting
error_reporting(0);
?>
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="images/saadi_foundation.png" width="48" height="60" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
بنیاد سعدی
                </div>
                <div class="email">
                    amoozesh@saadifoundation.ir
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 1395
                <a href="#">
                    معاونت آموزش و پژوهش بنیاد سعدی
                </a>.
            </div>
            <div class="version">
                <b>
                    نسخه:
                </b>
                0.0.1
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                فهرست متن های تایپ شده در سامانه پیکره زبان آموز بنیاد سعدی (تا تاریخ 2 آذر 95)
            </h2>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            فهرست متن های تایپ شده در سامانه پیکره زبان آموز بنیاد سعدی (تا تاریخ 2 آذر 95)
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>
#
                                </th>
                                <th>
موضوع متن
                                </th>
                                <th>
نوع متن
                                </th>
                                <th>
تاریخ تایپ
                                </th>
                                <th>
سطح زبان آموز
                                </th>
                                <th>
ملیت
                                </th>
                                <th>
تایپ کننده
                                </th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    موضوع متن
                                </th>
                                <th>
                                    نوع متن
                                </th>
                                <th>
                                    تاریخ تایپ
                                </th>
                                <th>
                                    سطح زبان آموز
                                </th>
                                <th>
                                    ملیت
                                </th>
                                <th>
                                    تایپ کننده
                                </th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            for($i = 0; $i < count ( $AllTexts ); $i ++) {
                                $j = $i + 1;
                                $id = $AllTexts[$i] ['Text_ID'];
                                $Type_Text_ID = $AllTexts[$i] ['Type_Text_ID'];
                                $Date_Type = $AllTexts[$i] ['Date_Type'];
                                $Subject = $AllTexts[$i] ['Subject'];
                                $Level_Text_ID = $AllTexts[$i] ['Level_Text_ID'];
                                $Nationality = $AllTexts[$i] ['Nationality'];
                                $Typist_ID = $AllTexts[$i] ['Typist_ID'];

                                //Text Type
                                $queryType = "SELECT * FROM type_text WHERE Type_Text_ID='$Type_Text_ID'";
                                $resultType = mysqli_query ( $coo, $queryType);
                                $mrowType = mysqli_fetch_assoc ( $resultType) ;
                                $Type_Text = $mrowType['Type_Text'];
                                //Date
                                $birthDate = substr ( $Date_Type, 0, 10 );
                                $Jalali_Date = new persian_date ();
                                $Jalali_Date_Type =  $Jalali_Date->to_date ( $birthDate, 'Y/m/d' );
                                //Level
                                $queryLevel = "SELECT * FROM level_text WHERE Level_Text_ID='$Level_Text_ID'";
                                $resultLevel = mysqli_query ( $coo, $queryLevel);
                                $mrowLevel = mysqli_fetch_assoc ( $resultLevel) ;
                                $Level_Name = $mrowLevel['Level_Name'];
                                $Level_Institute = $mrowLevel['Level_Institute'];
                                //Typist
                                $queryTypist = "SELECT * FROM user WHERE User_ID='$Typist_ID'";
                                $resultTypist = mysqli_query ( $coo, $queryTypist);
                                $mrowTypist = mysqli_fetch_assoc ( $resultTypist) ;
                                $Typist = $mrowTypist['First_Name']." ".$mrowTypist['Last_Name'];

                                //create table
                                echo "<tr>";
                                echo "<th>".$j;
                                echo "</th>";
                                echo "<th><a href='javascript:void(0);' data-toggle='modal' data-target='#text-".$AllTexts[$i] ['Text_ID']."'>".$Subject;
                                echo "</a></th>";
                                echo "<th>".$Type_Text;
                                echo "</th>";
                                echo "<th>".$Jalali_Date_Type;
                                echo "</th>";
                                echo "<th>".$Level_Name.
                                " (". $Level_Institute.
                                ")";
                                echo "</th>";
                                echo "<th>".$Nationality;
                                echo "</th>";
                                echo "<th>".$Typist;
                                echo "</th>";
                                echo "</tr>";
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>
<?php
for($i = 0; $i < count ( $AllTexts ); $i ++) {
    $SubjectModal = $AllTexts[$i] ['Subject'];
    $TextModal = $AllTexts[$i] ['Text'];
    echo "<!-- Modal for rules -->
<div class='modal fade' id='text-".$AllTexts[$i] ['Text_ID']."' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content modal-col-blue'>
            <div class='modal-header'>
                <h4 class='modal-title text-center' id='smallModalLabel'>".
        $SubjectModal.
                    "<br>
                    <small class='bg-cyan'>

                    </small>
                </h4>
            </div>
            <div class='modal-body'>".
                $TextModal."
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-link waves-effect' data-dismiss='modal'>
<span>
خروج
</span>
                </button>
            </div>
        </div>
    </div>
</div>";
}
?>

<!-- Modal for rules -->
<div class='modal fade' id='text' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content modal-col-blue'>
            <div class='modal-header'>
                <h4 class='modal-title text-center' id='smallModalLabel'>
                    قوانین و شرایط عضویت
                    <br>
                    <small class='bg-cyan'>
                        (آخرین تغییر: 22 آبان 1395- 12 نوامبر 2016)
                    </small>
                </h4>
            </div>
            <div class='modal-body'>
                <ol>
                    <li>
                        «سامانه‌ی جامع مرکز آموزش زبان فارسی بنیاد سعدی» سامانه‌ای برای مدیریت مجازی برنامه‌های آموزشی و پژوهشی مرکز آموزش زبان فارسی بنیاد سعدی (در زمینه‌ی آموزش زبان فارسی ادبیات فارسی و آشنایی با ایران) است. مخاطب این سامانه، علاقمندان به یادگیری زبان و ادبیات فارسی، علاقمندان آشنایی با ایران و متخصصان آموزش زبان فارسی و ایران‌شناسی هستند.
                    </li>
                    <li>
                        با عضویت در این سامانه، می‌پذیرید که مخاطب سامانه هستید، در راستای اهداف سامانه فعالیت می‌کنید و قوانین سامانه و همچنین قوانین جمهوری اسلامی ایران (در محدوده‌ی فعالیت‌های مجازی) را رعایت می‌کنید.
                    </li>
                    <li>
                        هرگونه اطلاعاتی که در سامانه وارد می‌کنید، باید واقعی و مربوط به خودتان باشد. اطلاعات شما نباید شامل محتوای غیراخلاقی یا توهین‌آمیز باشد. وارد کردن اطلاعات مستعار ممنوع است. مسئولیت انتشار همه‌ی مطالب شما بر عهده‌ی خودتان است.
                    </li>
                    <li>
                        شما نباید هیچ‌گونه تغییری در کدهای سامانه بدهید یا کدهای مخرب در آن وارد کنید.
                    </li>
                    <li>
                        شما نباید از محتوا یا ساختار فنی سامانه، در هیچ جای دیگر، بدون اجازه‌ی رسمی از مسئولان معاونت آموزش و پژوهش (ایمیل amoozesh[at]saadifoundation[dot]ir) استفاده کنید.
                    </li>
                    <li>
                        اگر شما در سامانه، خلاف این قوانین عمل کنید، اول با تذکر مسئول سایت روبرو می‌شوید و در صورت توجه نکردن به تذکر، بر اساس زمان‌بندی مسئول سایت، حساب کاربری شما مسدود خواهد شد.
                    </li>
                </ol>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-link waves-effect' data-dismiss='modal'>
<span>
خروج
</span>
                </button>
            </div>
        </div>
    </div>
</div>

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

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/pages/tables/jquery-datatable.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
</body>

</html>