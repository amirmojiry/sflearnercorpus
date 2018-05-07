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
		
		//query for types of texts
        $query = "SELECT * FROM type_text";
        $result = mysqli_query ( $coo, $query );

        if ($result)
        {
            if ($result->num_rows > 0)
            {
                $cntr = 0;
				$Types = array ();
                while ( $mrow = mysqli_fetch_assoc ( $result ) )
                {
                    $Types [$cntr] = $mrow;
                    $cntr ++;
                }
            }
        }
		
		//query for labels
		$query_level_text = "SELECT * FROM level_text";
        $result_level_text = mysqli_query ( $coo, $query_level_text );

        if ($result_level_text)
        {
            if ($result_level_text->num_rows > 0)
            {
				$number_level_text = 0;
				$Levels = array ();
                while ( $mrow_level_text = mysqli_fetch_assoc ( $result_level_text ) )
                {
                    $Levels [$number_level_text] = $mrow_level_text;
					$number_level_text ++;
                }
            }
        }
    }
}

$query=mysqli_query($coo,"SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $userRow['First_Name']; ?> - خوش آمدی</title>
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

    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>
<body dir="rtl" class="theme-red">
<?php include 'header.php';?>
<?php include 'left_sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                وارد کردن متن
            </h2>
        </div>
        <!-- Textarea -->
        <div class="row clearfix">
            <form method="post" action="insertdata.php">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            وارد کردن متن
                        </h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">
متن نگارش
                            <small>
اگر بخشی از اطلاعات را ندارید، خالی بگذارید.
                            </small>
                        </h2>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            نام نویسنده متن
                                        </small>
                                        <input type="text" name="author_name" autofocus maxlength="100"
                                               class="form-control" placeholder="نام نویسنده متن" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            شماره دانشجویی نویسنده
                                        </small>
                                        <input type="text" type="number" name="author_studentnumber" maxlength="20"
                                               class="form-control" placeholder="شماره دانشجویی نویسنده" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                    نوع آزمون
                                        </small>
                                        <select class="form-control show-tick" id="type_text" name="type_text" required>
                                            <option value="">
                                                نوع آزمون
                                            </option>
                                            <?php
											for($i = 0; $i < count ( $Types); $i ++) {
												echo "<option value='".$Types[$i]['Type_Text_ID'].
                                                    "'>".$Types[$i]['Type_Text']."</option>";
											}
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            موضوع متن
                                        </small>
                                        <input type="text" name="subject" required maxlength="50"
                                               class="form-control" placeholder="موضوع متن" />
                                    </div>
                                </div>
                            </div>
						    <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            ملیت
                                        </small>
                                        <input type="text" name="Nationality" required maxlength="50"
                                               class="form-control" placeholder="ملیت" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
نمره
                                        </small>
                                            <input type="number" name="score" placeholder="نمره"
                                                   min="0" max="21" step="0.01"
                                                   class="form-control"  />

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
سطح نویسنده
                                        </small>
                                        <select class="form-control show-tick" name="level_text_id" required >
                                            <option value="">
سطح نویسنده
                                            </option>
                                            <?php
											for($i = 0; $i < count ( $Levels); $i ++) {
												echo "<option value='".$Levels[$i]['Level_Text_ID'].
                                                    "'>".$Levels[$i]['Level_Name']." (".$Levels[$i]['Level_Institute'].
                                                    ")"."</option>";
											}
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <small>
                                            متن
                                        </small>
                                        <textarea rows="2"  name="text" required class="form-control no-resize auto-growth" placeholder="" style="font-size: 30px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-lg bg-red waves-effect center-block">
                                        ثبت
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- #END# Textarea -->
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

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/pages/forms/basic-form-elements.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
</body>
</html>