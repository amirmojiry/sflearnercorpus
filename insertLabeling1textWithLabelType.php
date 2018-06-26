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

	//query for labels
	$query_label = "SELECT * FROM label_text WHERE label_type='".$_POST['label_type']."'";
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
}

$query=mysqli_query($coo,"SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
متن شما برچسب خورد
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

    <!-- labeling Text -->
    <link href="css/labelingText.css" rel="stylesheet" />
	<style>
	<?php
	for($i = 0; $i < count ($AllLabels); $i ++) {
		$label_bg_color = $AllLabels[$i]['bg-color'];
		$label_name = $AllLabels[$i]['name'];
		echo "$label_name, .$label_name {
				background-color: $label_bg_color;
				color: white;
			}";
	}
	?>
	</style>

</head>
</head>
<body dir="rtl" class="theme-red">
<?php include 'header.php';?>
<?php include 'left_sidebar.php'; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
متن برچسب گذاری شده ذخیره شد.
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php  // چاپ داده های ارسالی
                        $text_id = $_POST['text_id'];
                        $label_type = $_POST['label_type'];
                        $LabeledText = trim($_POST['LabeledText']);
                        $labeler_id=$_SESSION['user'];
                        //is this text in labeled_text table?
                        $query_labeled_text = mysqli_query($coo,"SELECT * FROM labeled_text WHERE text_id='$text_id'");
                        if ($query_labeled_text->num_rows > 0) {
                          //update
                          $query = "UPDATE labeled_text
                            SET labeled_text = '$LabeledText',
                            label_type = '$label_type',
                            labeler_id = '$labeler_id',
                            timeof = NOW()
                            WHERE text_id = '$text_id'";
                        } else {
                          //insert
                          $query = "INSERT INTO labeled_text (text_id, labeled_text, label_type, labeler_id, timeof)
                            VALUES ('$text_id',
                              '$LabeledText',
                              '$label_type',
                              '$labeler_id',
                              NOW())";
                        }
                        $r = mysqli_query($coo,$query);
                        if ($r)  { // اگر درست اجرا شد
                            $id_query="SELECT * FROM text WHERE Text_ID =".$text_id;
                            $id_query_func= mysqli_query($coo,$id_query);
                            while($row = mysqli_fetch_assoc($id_query_func)) {
                                $subject = $row['Subject'];
                                $author_name = $row['Author_Name'];
                                $author_studentnumber = $row['Author_StudentNumber'];
                                $nationality = $row['Nationality'];
                                $level_text_id = $row['Level_Text_ID'];
                                $score = $row['Score'];
                                $type_text_id = $row['Type_Text_ID'];
                                $type_text=mysqli_fetch_assoc(mysqli_query($coo,"SELECT * FROM type_text WHERE Type_Text_ID=". $type_text_id));
                                $text =  $row['Text'];

                                $LabeledText=mysqli_fetch_assoc(
                                              mysqli_query(
                                                $coo,"SELECT * FROM labeled_text WHERE text_id=".$text_id." AND label_type='".$label_type."'"))["labeled_text"];
                                ?>
                                <div class="card">
                                    <div class="header bg-red">
                                        <h2>
                                            اطلاعات متن
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <small>
برچسب زننده متن:
                                                </small>
                                                <?php echo $userRow['First_Name'].' '.$userRow["Last_Name"]; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
                                        موضوع متن:
                                                </small>
                                                <?php echo $subject; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
                                        نام نویسنده متن:
                                                </small>
                                                <?php echo $author_name; ?>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <small>
                                        شماره دانشجویی:
                                                </small>
                                                <?php echo $author_studentnumber; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
ملیت:
                                                </small>
                                                <?php echo $nationality; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
نوع متن:
                                                </small>
                                                <?php echo $type_text["Type_Text"]; ?>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <small>
سطح نویسنده:
                                                </small>
                                                <?php echo $level_text_id; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
نمره:
                                                </small>
                                                <?php echo $score; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <small>
                                کد برگه:
                                                </small>
                                                <?php echo $userRow['User_Code']."-". $row['Text_ID']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="header bg-cyan">
                                        <h2>
متن اصلی
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <?php echo $text; ?>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="header bg-green">
                                        <h2>
متن برچسب خورده
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <?php echo $LabeledText; ?>
                                    </div>
                                </div>
                            <?php }
                        }else { // اگر درست اجرا نشد
                            echo '<p>' . mysqli_error($coo) . '<br /><br />Query: ' . $query . '</p>';  }
                        ?>
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
