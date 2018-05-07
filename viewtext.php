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

    }
}

$query=mysqli_query($coo, "SELECT * FROM user WHERE User_ID=".$_SESSION['user']);
$userRow=mysqli_fetch_assoc($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> جستجوی متن </title>
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

    <script>
        function validateTextID() {
            var Text_ID, output = true;

            Text_ID = document.frmSearchText.Text_ID;

            if(!Text_ID.value) {
                Text_ID.focus();
                document.getElementById("Text_ID").innerHTML = "پر کردن این بخش لازم است.";
                output = false;
            }
            return output;
        }
    </script>
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
جستجوی متن (
                <?php

                if ($cntr > 0) { 
                    echo "در $cntr متن";
                }
                else {
                    echo 'هیچ متن در سامانه نیست.'; 
				}
                ?>
                )
                <small>
                    برای جستجو فقط شماره ی متن (بدون کد اختصاصی) را وارد کنید. مثال درست: 760- مثال غلط: am-760
                </small>
            </h2>
        </div>
        <form name="frmSearchText" method="post"
              action="" onSubmit="return validateTextID()">
            <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="Text_ID" class="required"></span>
                                <small>
    شماره متن
                                </small>
                                <input type="number" name="Text_ID" maxlength="20" required
                                       class="form-control" placeholder= "شماره متن" />
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
جستجو
                        </button>
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </form>
        <div class="row clearfix">
            <?php
			if (count ($_POST==0) && count($_GET==0)) {
				if(count($_POST)>0) {
					$text_post = $_POST["Text_ID"];
					$text_query= mysqli_query($coo,"SELECT * FROM text WHERE Text_ID =".$text_post);
					$text = mysqli_fetch_assoc($text_query);
					$text_num = mysqli_num_rows($text_query);
					$Text_ID = $text["Text_ID"];
					$typist_ID = $text["Typist_ID"];
					$Date_Type = $text["Date_Type"];
					$Author_Name = $text["Author_Name"];
					$Score = $text["Score"];
					$Author_StudentNumber = $text["Author_StudentNumber"];
					$Nationality = $text["Nationality"];
					$Subject = $text["Subject"];
					$typist_query = mysqli_query($coo,"SELECT * FROM user WHERE User_ID =".$typist_ID);
					$Typist = mysqli_fetch_assoc($typist_query);
					$type_text_ID = $text["Type_Text_ID"];
					$type_text_result=mysqli_query($coo,"SELECT * FROM type_text WHERE Type_Text_ID=".$type_text_ID);
					$type_text=mysqli_fetch_assoc($type_text_result);
					$type_text_name = $type_text["Type_Text"];
					$Level_Text_ID = $text["Level_Text_ID"];
					$Level_Text_ID_result=mysqli_query($coo,"SELECT * FROM level_text WHERE Level_Text_ID=".$Level_Text_ID);
					$level_text=mysqli_fetch_assoc($Level_Text_ID_result);
					$Level_Name = $level_text["Level_Name"];
					$Level_Institute = $level_text["Level_Institute"];
				}
				elseif(count($_GET)>0) {
					$text_post = $_GET["ID"];
					$text_query= mysqli_query($coo,"SELECT * FROM text WHERE Text_ID =".$text_post);
					$text = mysqli_fetch_assoc($text_query);
					$text_num = mysqli_num_rows($text_query);
					$Text_ID = $text["Text_ID"];
					$typist_ID = $text["Typist_ID"];
					$Date_Type = $text["Date_Type"];
					$Author_Name = $text["Author_Name"];
					$Score = $text["Score"];
					$Author_StudentNumber = $text["Author_StudentNumber"];
					$Nationality = $text["Nationality"];
					$Subject = $text["Subject"];
					$typist_query = mysqli_query($coo,"SELECT * FROM user WHERE User_ID =".$typist_ID);
					$Typist = mysqli_fetch_assoc($typist_query);
					$type_text_ID = $text["Type_Text_ID"];
					$type_text_result=mysqli_query($coo,"SELECT * FROM type_text WHERE Type_Text_ID=".$type_text_ID);
					$type_text=mysqli_fetch_assoc($type_text_result);
					$type_text_name = $type_text["Type_Text"];
					$Level_Text_ID = $text["Level_Text_ID"];
					$Level_Text_ID_result=mysqli_query($coo,"SELECT * FROM level_text WHERE Level_Text_ID=".$Level_Text_ID);
					$level_text=mysqli_fetch_assoc($Level_Text_ID_result);
					$Level_Name = $level_text["Level_Name"];
					$Level_Institute = $level_text["Level_Institute"];
				}
				echo "
				    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						<div class='card'>";
                if(isset($text_post)) 
				{
                    if ($text_num <= 0) 
					{
                        echo " متنی با شماره ی ".$text_post." وجود ندارد.";
					}
					else 
					{
						echo"
							<div class='header'>
								<h2>
									موضوع متن:".$Subject."-".$Text_ID
								."</h2>
							</div>
							<div class='body'>
								<div class='row clearfix'>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													نام نویسنده متن
												</small>".$Author_Name
											."</div>
										</div>
									</div>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													شماره دانشجویی نویسنده
												</small>".$Author_StudentNumber
											."</div>
										</div>
									</div>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													نوع آزمون
												</small>".$type_text_name
											."</div>
										</div>
									</div>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
		تایپیست
												</small>".$Typist['First_Name']." ".$Typist['Last_Name']
											."</div>
										</div>
									</div>
								</div>
								<div class='row clearfix'>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
		موضوع
												</small>".$Subject
											."</div>
										</div>
									</div>                            
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
		ملیت
												</small>".$Nationality
											."</div>
										</div>
									</div>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													نمره
												</small>".$Score
											."</div>
										</div>
									</div>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													سطح نویسنده
												</small>".$Level_Name."- ".$Level_Institute
											."</div>
										</div>
									</div>
								</div>
								<div class='row clearfix'>
									<div class='col-sm-3'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
		تاریخ تایپ
												</small>".$Date_Type
											."</div>
										</div>
									</div>  
								</div>							
								<div class='row clearfix'>
									<div class='col-sm-12'>
										<div class='form-group'>
											<div class='form-line'>
												<small>
													متن
												</small><p style='font-size:30px'>".nl2br($text['Text'])
											."</p></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>";
					}
                }
                
			}
			else {
				echo "شماره ی یک متن را در کادر جستجو وارد کنید.";
			}
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

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>
</html>