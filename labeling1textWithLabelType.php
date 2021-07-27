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

//if no get (id)
if(!isset ($_GET['ID'])) {
  die ('This is wrong! :)');
}
//if no label type gets.
if (!isset ($_GET['label_type'])) {
  die ('Could Not Get Label Type');
} else {
  $label_type = $_GET['label_type'];
}

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

		$query = "SELECT * FROM label_text WHERE label_type='".$label_type."'";
        $result = mysqli_query ( $coo, $query );

        if ($result)
        {
            if ($result->num_rows > 0)
            {
                $cntr = 0;
		        $AllLabels = array ();
                while ( $mrow = mysqli_fetch_assoc ( $result ) )
                {
                    $AllLabels [$cntr] = $mrow;
                    $cntr ++;
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
      برچسب گذاری متن
        <?php echo ' '.$_GET['ID']; ?>
         بر اساس نوع
         <?php echo ' '.$_GET['label_type']; ?>
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

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />

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
	   }
	   else {
	       	for($i = 0; $i < count ($AllLabels); $i ++) {
                $label_bg_color = $AllLabels[$i]['bg-color'];
                $label_name = $AllLabels[$i]['name'];
                echo "$label_name, .$label_name {
                        background-color: $label_bg_color;
                        color: white;}";
	        }
	   }
	?>
	</style>

</head>
<body dir="rtl" class="theme-red">
<?php
include 'header.php';
include 'left_sidebar.php';
?>

<section class="content">
    <div class="container-fluid">
        <?php
        if(count($_GET)>0) {
            $text_post = $_GET["ID"];
            $text_query= mysqli_query($coo,"SELECT * FROM text WHERE Text_ID =".$text_post);
            if (mysqli_num_rows($text_query) > 0) {
                $text = mysqli_fetch_assoc($text_query);
                $text_num = mysqli_num_rows($text_query);
                $Text_ID = (isset($text["Text_ID"])) ? $text["Text_ID"] : "";
                $typist_ID = (isset($text["Typist_ID"])) ? $text["Typist_ID"] : "";
                $Date_Type = (isset($text["Date_Type"])) ? $text["Date_Type"] : "";
                $Author_Name = ($text["Author_Name"]!='') ? $text["Author_Name"] : "";
                $Score = ($text["Score"]!= 0) ? $text["Score"] : "";
                $Author_StudentNumber = ($text["Author_StudentNumber"]!='') ? $text["Author_StudentNumber"] : "";
                $MyText = ($text["Text"]!='') ? $text["Text"] : "";

                //get from label_text table
                $LabeledText_result = mysqli_fetch_assoc(mysqli_query($coo,"SELECT * FROM labeled_text WHERE text_id=".$Text_ID." AND label_type='".$label_type."'"));
                $LabeledText = (isset($LabeledText_result)) ? $LabeledText_result["labeled_text"] : null;
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
            else {
                echo "متنی با این شماره وجود ندارد!";
            }
        }
        else {
            echo "شما اشتباهی به این صفحه آمده اید!";
        }
        ?>
        <div class="block-header">
            <h2>
                برچسب گذاری متن بر اساس 
                <?= $_GET['label_type']; ?>
            </h2>
        </div>
			<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- Buttons for view labelled sentences into "div text" -->
					<div class="card">
						<div class="header">
                            <h2>
                                دکمه های دیدن برچسب ها
								<small>
										با کلیک روی هر کدام از دکمه های زیر، برچسب های مربوط به آن نمایش داده می شوند.
								</small>
                            </h2>
                        </div>
						<div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button type="button" class="btn bg-teal btn-block btn-xs waves-effect"
										data-toggle="collapse" data-target="#ViewButtons" onclick='
										<?php
											for($i = 0; $i < count ($AllLabels); $i ++) {
												$label_name = $AllLabels[$i]['name'];
												echo "countTag(\"".$label_name."\", \"".$label_name."_number\"); ";
												}
										?>
										'>
											دیدن دکمه ها
									</button>
								</div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse" id="ViewButtons" name="ViewButtons">
									<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
										<div class="btn-group" role="group" aria-label="First group">
											<?php
											for($i = 0; $i < count ($AllLabels); $i ++) {
												$label_name = $AllLabels[$i]['name'];
												$label_name_fa = $AllLabels[$i]['name_fa'];
												echo "<button type='button' class='btn waves-effect ".$label_name."' id='".$label_name."_view_button' "
												        ." onclick='countTag(\"".$label_name."\", \"".$label_name."_number\");
												             showATag(\"".$label_name."\", \"".$label_name."_view_button\");'
												      >".$label_name_fa
												      ." (<span id='".$label_name."_number'></span>)</button>";
												}
											?>
										</div>
									</div>
								</div>
								<div id='view_labels'>
								</div>
							</div>
						</div>
					</div>
					<!-- #END# Buttons for view labelled sentences into "div text" -->
										<!-- Buttons for labelling -->
                    <div class="card">
                        <div class="header">
                            <h2>
                                دکمه های برچسب زنی
								<small>
									لطفا با دکمه های زیر به برچسب زنی اقدام کنید. اگر اشتباه برچسب زدید باید روی «دیدن متن برچسب خورده» کلیک کنید و اشتباه را با پاک کردن کدها (آغاز و پایان برچسب) اصلاح کنید.
								</small>
							</h2>
                        </div>
						<div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group" role="group" aria-label="First group">
										<?php
										for($i = 0; $i < count ($AllLabels); $i ++) {
											$label_name = $AllLabels[$i]['name'];
											$label_name_fa = $AllLabels[$i]['name_fa'];
											echo "<button type='button' class='btn waves-effect ".$label_name."'"
											." onclick='getSelectionHtml(\"".$label_name."\");'>".$label_name_fa
											."</button>";
										}
										?>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<!-- #END# Buttons for labelling -->
					<div class="card">
						<div class="header">
                            <h2>
                                مشخصات متن
                            </h2>
                        </div>
						<div class="body">
							<form method="post" action="insertLabeling1textWithLabelType.php">
								<input type="hidden" name="text_id" value="<?php if (isset($Text_ID)) {echo $Text_ID;} ?>">
                <input type="hidden" name="label_type" value="<?php if (isset($label_type)) {echo $label_type;} ?>">
								<div class="row clearfix">
									<div class="col-sm-12">
										<div class="form-group">
											<div class="form-line">
												<small>
													متن
												</small>
												<div name="text" id="text"><?php if(isset($LabeledText)){echo $LabeledText;}elseif(isset($MyText)){echo $MyText;}?></div>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<button type="button" class="btn bg-teal btn-block btn-xs waves-effect"
												data-toggle="collapse" data-target="#LabeledDiv"
												onclick="changeTextareaToLabeledText()">
											دیدن متن برچسب خورده
										</button>
										<div id="LabeledDiv" name="LabeledDiv" class="collapse">
											<textarea id="LabeledText" name="LabeledText" dir='ltr'
                      class="form-control no-resize" required rows="8" onkeyup="editTextarea()" onmousedown="editTextarea()"></textarea>
											<button type="button" class="btn bg-teal btn-xs waves-effect"
											onclick="editTextarea()">
											اعمال ویرایش متن برچسب خورده
											</button>
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
							</form>
														<div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                نام نویسنده متن
                                            </small>
                                            <div class="form-control">
                                                <?php if (isset($Author_Name)) {
                                                    echo $Author_Name;
                                                }
                                                else {
                                                    echo "نامشخص";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                شماره دانشجویی نویسنده
                                            </small>
                                            <div class="form-control " >
                                                <?php
                                                if (isset($Author_StudentNumber)) {
                                                    echo $Author_StudentNumber;
                                                }
                                                else {
                                                    echo "نامشخص";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                نوع آزمون
                                            </small>
                                            <div class="form-control">
                                                <?php
                                                $queryType=mysqli_query($coo,"SELECT * FROM type_text");
                                                while ($TypeRow=mysqli_fetch_assoc($queryType)){
                                                    if ($type_text_ID == $TypeRow['Type_Text_ID']) {
                                                        echo $TypeRow['Type_Text'];
                                                    }
                                                }
                                                ?>
                                            </div>
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
                                            <div class="form-control" name="subject">
                                                <?php if (isset($Subject)) {echo $Subject;} ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                ملیت
                                            </small>
                                            <div class="form-control" >
                                                <?php if (isset($Nationality)) {
                                                    echo $Nationality;
                                                }
                                                else {
                                                    echo "نامشخص";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                نمره
                                            </small>
                                            <div class="form-control" >
                                                <?php if (isset($Score)) {
                                                    echo $Score;
                                                }
                                                else {
                                                    echo "نامشخص";
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <small>
                                                سطح نویسنده
                                            </small>
                                            <div class="form-control">
                                                <?php
                                                $queryLevel=mysqli_query($coo,"SELECT * FROM level_text");
                                                while ($levelRow=mysqli_fetch_assoc($queryLevel)){
                                                    if ($Level_Text_ID == $levelRow['Level_Text_ID']) {
                                                        echo $levelRow['Level_Name'] . " (" . $levelRow['Level_Institute'] . ")";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Custom Js -->
<script src="js/admin.js"></script>
<script src="js/pages/forms/basic-form-elements.js"></script>

<!-- Demo Js -->
<script src="js/demo.js"></script>
<script>
    function changeTextareaToLabeledText(){
        document.getElementById('LabeledText').value = document.getElementById('text').innerHTML;
    }
    function editTextarea(){
        document.getElementById('text').innerHTML = document.getElementById('LabeledText').value;
    }
    function getSelectionHtml(tag) {
        var sel, range;
        if (window.getSelection && window.getSelection().toString() != "") {
            sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                // save selection text in a var (range)
                range = window.getSelection().getRangeAt(0);
                //create a var for save html tags of range
                var clonedSelection = range.cloneContents();
                var rangeWithHTMLs = document.createElement('div');
                rangeWithHTMLs.appendChild(clonedSelection);
                // tagging range
                var tag = tag;
                var startTag = '<'+tag+'>';
                var EndTag = '</'+tag+'>';
                var html = startTag + rangeWithHTMLs.innerHTML + EndTag;
                //delete content of range because of saving range (with html tags) in a var (html)
                range.deleteContents();

                var el = document.createElement("div");
                el.innerHTML = html;
                var frag = document.createDocumentFragment(), node, lastNode;
                node = el.firstChild;
                lastNode = frag.appendChild(node);

                range.insertNode(frag);
            }
        }
        else if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            range.collapse(false);
            range.pasteHTML(html);
        }
        changeTextareaToLabeledText();
    }
	function countTag(tag, tag_number) {
		//count labelled tags into "text div"
		var selected_tag = document.getElementById('text').getElementsByTagName(tag);
		document.getElementById(tag_number).innerHTML = selected_tag.length;
		}
	function showATag(tag, tag_view_button) {
		//Show a tag and hide other tags.
		var view_labels = document.getElementById('view_labels');
		view_labels.innerHTML = '';
		view_labels.innerHTML = 'عبارت ها با برچسب: ';
		view_labels.innerHTML += document.getElementById(tag_view_button).innerHTML;
		view_labels.innerHTML += '<br>';
		var i;
		for (i=0; i < document.getElementsByTagName(tag).length && i < 100; i++) {
			view_labels.innerHTML += '<br>';
			var sort = i + 1;
			view_labels.innerHTML += sort;
			view_labels.innerHTML += '- ';
			view_labels.innerHTML += document.getElementsByTagName(tag)[i].innerHTML;
		}
	}
</script>
</body>
</html>>
