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
$query=mysqli_query($coo,"SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        ویرایش متن
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

    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>
</head>
<body dir="rtl" class="theme-red">
<?php include 'header.php';?>
<?php include 'left_sidebar.php'; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                این متن ویرایش شد.
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            این متن ویرایش شد.
                            <small>
لطفا شماره برگه را بررسی کنید.
                            </small>
                        </h2>
                    </div>
                    <div class="body">
                        <?php  // چاپ داده های ارسالی
                        $text_id = $_POST['text_id'];
                        $subject = $_POST['subject'];
                        $typist_id=$_SESSION['user'];
                        $nationality = $_POST['Nationality'];
                        $author_name= $_POST['author_name'];
                        $author_studentnumber= $_POST['author_studentnumber'];
                        $type_text_id = $_POST['type_text'];
                        $type_text_result=mysqli_query($coo,"SELECT * FROM type_text WHERE Type_Text_ID=".$_POST['type_text']);
                        $type_text=mysqli_fetch_assoc($type_text_result);
                        $level_text_id = $_POST['level_text_id'];
                        $score = $_POST['score'];
                        $text = nl2br($_POST['text']);
                        $editor_id=$_SESSION['user'];

                        //update data to database
                        $query = "UPDATE text
    SET Text = '$text',
    Type_Text_ID = '$type_text_id',
    Subject = '$subject',
    Level_Text_ID = '$level_text_id',
    Score = '$score',
    Date_Edit = NOW() ,
    Editor_ID = '$editor_id',
    Nationality = '$nationality',
    Author_Name = '$author_name',
    Author_StudentNumber = '$author_studentnumber'
    WHERE Text_ID = '$text_id'";
                        $r = mysqli_query($coo,$query);
                        if ($r)  { // اگر درست اجرا شد
                            $id_query="SELECT * FROM text WHERE Text_ID =".$text_id;
                            $id_query_func= mysqli_query($coo,$id_query);
                            while($row = mysqli_fetch_assoc($id_query_func)) {
                                echo "<span id='text_code'> کد برگه: ".$userRow['User_Code']."-". $row['Text_ID']."</span>";
                                echo "<br>";
                            }
                        }else { // اگر درست اجرا نشد
                            echo '<p>' . mysqli_error($coo) . '<br /><br />Query: ' . $query . '</p>';  }
                        mysqli_close($coo); // Close the database connection.
                        ?>

                        <table align="center" width="70%" border="0">
                            <tr><td>تایپ کننده متن: </td><td><?php echo $userRow['First_Name']." ".$userRow['Last_Name'] ?></tr></td>
                            <tr><td>موضوع متن: </td><td><?php echo $subject; ?></tr></td>

                            <tr><td>نام نویسنده متن: </td><td><?php echo $author_name; ?></tr></td>
                            <tr><td>شماره دانشجویی: </td><td><?php echo $author_studentnumber; ?></tr></td>

                            <!-- <tr><td>نام کشور نویسنده متن: </td><td><?php echo $nationality; ?></tr></td> -->
                            <tr><td>نوع متن: </td><td><?php echo $type_text["Type_Text"]; ?></tr></td>
                            <!-- <tr><td>سطح نویسنده (شماره کتاب): </td><td><?php echo $level_text_id; ?></tr></td> -->
                            <!-- <tr><td>نمره: </td><td><?php echo $score; ?></tr></td> -->
                        </table>
                        <table align="center" width="70%" border="0">
                            <tr><td>متن: </td></tr>
                            <tr><td><?php echo $text; ?></tr></td>
                        </table>
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

<!-- SweetAlert Plugin Js -->
<script src="plugins/sweetalert/sweetalert.min.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/pages/ui/dialogs.js"></script>
<script>
    $( document ).ready(function() {
        showUpdateData();
    });
</script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
</body>
</html>