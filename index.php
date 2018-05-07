<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
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

}


if(isset($_POST['btn-login']))
{
 $username = mysqli_real_escape_string($coo, $_POST['username']);
 $password = mysqli_real_escape_string($coo, $_POST['password']);
 $query=mysqli_query($coo,"SELECT * FROM user WHERE Username='$username'");
 $row=mysqli_fetch_assoc($query);
 if($row['Password']==$password)
 {
  $_SESSION['user'] = $row['User_ID'];
  header("Location: home.php");
 }
 else
 {
  ?>
        <script>alert('اشتباه در نام کاربری یا گذرواژه');</script>
        <?php
 }
 
}
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">
<title>ورود به سامانه پیکره زبان آموز بنیاد سعدی</title>
<!-- Favicon-->
<link rel="icon" href="../favicon.ico" type="image/x-icon">

<!-- Google Fonts -->
<link
	href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext"
	rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet" type="text/css">

<!-- Bootstrap Core Css -->
<link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

<!-- Waves Effect Css -->
<link href="plugins/node-waves/waves.css" rel="stylesheet" />

<!-- Animation Css -->
<link href="plugins/animate-css/animate.css" rel="stylesheet" />

<!-- Custom Css -->
<link href="css/style.css" rel="stylesheet">

<style>
@font-face {
	font-family: 'Yekan';
	src: url('/font/Yekan.eot');
	src: local('BYekan'), url('fonts/Yekan.woff') format('woff'),
		url('font/Yekan.ttf') format('truetype'), url('Yekan.svg')
		format('svg');
	font-weight: normal;
	font-style: normal;
}

@font-face {
	font-family: 'Koodak';
	src: url('font/BKoodakBold.eot');
	src: url('font/BKoodakBold.eot?#iefix') format('embedded-opentype'),
		url('font/BKoodakBold.woff') format('woff'),
		url('font/BKoodakBold.ttf') format('truetype');
	font-weight: normal;
	font-style: normal;
}
</style>
</head>

<body class="login-page" style="font-family: 'Koodak';">
	<div class="login-box">
		<div class="logo">
			<a href="javascript:void(0);"> ورود </a> <small> سامانه <b>  پیکره زبان آموز بنیاد سعدی </b>
			</small>
		</div>
		<div class="card">
			<div class="body">
				<form id="sign_in" method="POST">			
					<div class="input-group">
						<span class="input-group-addon"> <i class="material-icons">person</i>
						</span>
						<div class="form-line">
							<input type="text" class="form-control" name="username"
								placeholder="نام کاربری شما" required autofocus>
						</div>

					</div>
					<div class="input-group">
						<span class="input-group-addon"> <i class="material-icons">lock</i>
						</span>
						<div class="form-line">
							<input type="password" class="form-control" name="password"
								placeholder="گذرواژه ی شما" required>
						</div>

					</div>
					<div class="row">
						<div class="col-xs-4">
							<button class="btn btn-block bg-pink waves-effect" type="submit" name="btn-login">
								ورود</button>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Jquery Core Js -->
	<script src="plugins/jquery/jquery.min.js"></script>

	<!-- Bootstrap Core Js -->
	<script src="plugins/bootstrap/js/bootstrap.js"></script>

	<!-- Waves Effect Plugin Js -->
	<script src="plugins/node-waves/waves.js"></script>

	<!-- Validation Plugin Js -->
	<script src="plugins/jquery-validation/jquery.validate.js"></script>

	<!-- Custom Js -->
	<script src="js/admin.js"></script>
	<script src="js/pages/examples/sign-in.js"></script>
</body>

</html>