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

        //fetch user information
        $query=mysqli_query($coo, "SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
        $userRow=mysqli_fetch_assoc($query);

        if ($userRow['Level'] == '1') {
            //query for texts
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
                        $AllTexts [$cntr] = $mrow;
                        $cntr ++;
                    }
                }
            }
            //query for labels
            $query_label = "SELECT * FROM label_text";
            $result_label = mysqli_query ( $coo, $query_label );

            if ($result_label)
            {
                if ($result_label->num_rows > 0)
                {
                    $number_label = 0;
                    $AllLabels = array ();
                    while ( $mrow_label = mysqli_fetch_assoc ( $result_label ) )
                    {
                        $AllLabels [$number_label] = $mrow_label;
                        $number_label ++;
                    }
                }
            }
        }
        else {
            die ("you can't access this page.");
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        پروفایل مدیریتی شما
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

    <!-- old labeling Text
    <link href="css/labelingText.css" rel="stylesheet" /> -->
    <style>
        <?php
           if (isset($_GET['label'])) {
               for($i = 0; $i < count ($AllLabels); $i ++) {
                   if ($_GET['label'] == $AllLabels[$i]['name']) {
                       $label_name = $AllLabels[$i]['name'];
                       $label_bg_color = $AllLabels[$i]['bg-color'];
                       echo "$label_name, .$label_name {
                            background-color: $label_bg_color;
                            color: white;}";
                   }
               }
               $label_link = "&label=".$_GET['label'];
           }
       else {
            for($i = 0; $i < count ($AllLabels); $i ++) {
                $label_bg_color = $AllLabels[$i]['bg-color'];
                $label_name = $AllLabels[$i]['name'];
                echo "$label_name, .$label_name {
                        background-color: $label_bg_color;
                        color: white;}";
            }
            $label_link = "";
       }
        ?>
    </style>

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
                    <?php
                    echo "تعداد متون پیکره: ".$cntr;
                    ?>
                </small>
            </h2>
        </div>
        <!-- Count of each grammar item -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            هر نکته ی دستوری چند بار در پیکره هست؟
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <?php
                            for($i = 0; $i < count ($AllLabels); $i ++) {
                                $label_name = $AllLabels[$i]['name'];
                                $label_name_fa = $AllLabels[$i]['name_fa'];
                                echo "<div class='col-xs-6 col-sm-6 col-md-3 col-lg-3'>
													<a href='adminProfile.php?label=$label_name'><button class='btn btn-lg btn-block waves-effect $label_name' type='button'>".
                                    $label_name_fa.
                                    "<span class='badge'>";
                                $grammar = '<'.$label_name.'>';
                                $countGrammar = 0;
                                for($j = 0; $j < count ( $AllTexts); $j ++) {
                                    $countGrammar += substr_count($AllTexts[$j]['LabeledText'],$grammar);
                                }
                                echo $countGrammar;
                                echo "</span>
												</button></a>
												</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            همه ی متون پیکره
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
                                    تعداد برچسب
                                </th>
                                <th>
                                    سطح نویسنده
                                </th>
                                <th>
                                    برچسب زننده
                                </th>
                                <th>
                                    برچسب گذاری شده؟
                                </th>
                                <th>
                                    برچسب ها
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
                                  تعداد برچسب
                                </th>
                                <th>
                                    سطح نویسنده
                                </th>
                                <th>
                                    برچسب زننده
                                </th>
                                <th>
                                    برچسب گذاری شده؟
                                </th>
                                <th>
                                    برچسب ها
                                </th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            for($i = 0; $i < count ( $AllTexts); $i ++) {
                                if (isset($_GET['label'])){
                                    $firstOfTag = '<'.$_GET["label"].'>';
                                    $LabeledText = $AllTexts[$i]['LabeledText'];
                                    $countGrammar = substr_count($LabeledText,$firstOfTag);

                                    $AllOfTagRegExp = '/\<'.$_GET["label"].'>(.*)\<\/'.$_GET["label"].'>/';
                                    $allLabelsOfThisText = array();
                                    preg_match($AllOfTagRegExp, $LabeledText, $allLabelsOfThisText);
                                }
                                else {
                                    $grammar = '</';
                                    $countGrammar = substr_count($AllTexts[$i]['LabeledText'],$grammar);

                                    $allLabelsOfThisText = 0;
                                }
                                $labeling_with_label_type_link = '&label_type=word-formation';
                                echo '<tr>';
                                echo '<td>' . $AllTexts [$i]['Subject']
                                    . '<a href="viewtext.php?ID='.$AllTexts [$i]["Text_ID"].'">[<i class="material-icons font-12">remove_red_eye</i>] </a>'
                                    . '<a href="edittext.php?ID='.$AllTexts [$i]["Text_ID"].'">[<i class="material-icons font-12">edit</i>]</a>'
                                    . '<a href="labeling1text.php?ID='.$AllTexts [$i]["Text_ID"].$label_link.'">[<i class="material-icons font-12">description</i>]</a>'
                                    . '<a href="labeling1textWithLabelType.php?ID='.$AllTexts [$i]["Text_ID"]
                                    .$labeling_with_label_type_link.'">[<i class="material-icons font-12">format_quote</i>]</a>'
                                    . '</td>';

                                $type_text_result = mysqli_query ( $coo, "SELECT * FROM type_text WHERE Type_Text_ID=" . $AllTexts [$i]['Type_Text_ID']);
                                $type_text = mysqli_fetch_assoc($type_text_result);
                                echo '<td>' . $type_text["Type_Text"] . '</td>';
                                echo '<td>' . $countGrammar . '</td>';
                                // Level
                                $Level_Text_ID = $AllTexts [$i]['Level_Text_ID'];
                                $queryLevelText = "SELECT * FROM level_text WHERE Level_Text_ID='$Level_Text_ID'";
                                $resultLevelText = mysqli_query ( $coo, $queryLevelText);
                                $mrowLevelText = mysqli_fetch_assoc ( $resultLevelText) ;
                                $LevelText = $mrowLevelText ['Level_Name']." (".$mrowLevelText ['Level_Institute'].")";
                                echo '<td>' . $LevelText . '</td>';
                                $labeler_id = $AllTexts [$i]['Labeler_ID'];
                                $query = mysqli_query($coo, "SELECT * FROM user WHERE User_ID = $labeler_id");
                                if ($query !== FALSE) {
                                    $userRow=mysqli_fetch_assoc($query);
                                    $firstName = $userRow['First_Name'];
                                    $lastName = $userRow['Last_Name'];
                                } else {
                                    $firstName = $lastName = '';
                                }
                                echo "<td>$firstName $lastName</td>";
                                echo '<td>';
                                if ($AllTexts [$i]['LabeledText']==''){
                                    echo '<a href="labeling1text.php?ID='.$AllTexts [$i]["Text_ID"].'"><i class="material-icons" style="color:red">close</i></a>';
                                } else {
                                    echo '<a href="labeling1text.php?ID='.$AllTexts [$i]["Text_ID"].'"><i class="material-icons" style="color:green">check</i></a>';
                                }
                                echo '</td>';
                                echo '<td></td>';
                                echo '</tr>';
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
