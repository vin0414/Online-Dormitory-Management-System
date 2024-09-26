
<?php
include('resources/dbconfig.php');
$msg = "";$success = "";
try
{
    if(isset($_POST['btnContinue']))
    {
        $emails = $_POST['email'];
        $code = $_POST['code'];
        if(empty($code))
        {
            $msg = "Please enter the verification code";
        }
        else
        {
            $sql = "Select Fullname from tblcustomer WHERE EmailAddress=:email AND verification=:code";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':email',$emails);
            $stmt->bindParam(':code',$code);
            $stmt->execute();
            $count = $stmt->rowCount();
            $row   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row))
            {
                //update status
                $stmt = $dbh->prepare("update tblcustomer SET Status=1 WHERE EmailAddress=:email");
                $stmt->bindParam(':email',$emails);
                $stmt->execute();
                $success = "Your account was verified. Please login";
            }
            else
            {
                $msg = "Invalid Verification Code!";
            }
        }
    }
}
catch(Exception $e)
{
    echo $e->getMessage();
}
$dbh=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>J-M Dormitory Online Reservation</title>
	<!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="codedthemes">
	<meta name="keywords"
		  content=", Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
	<meta name="author" content="codedthemes">

	<!-- Favicon icon -->
	<link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
	<link rel="icon" href="assets/images/logo.png" type="image/x-icon">

	<!-- Google font-->
   <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

	<!-- iconfont -->
	<link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">

	<!-- waves css -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/Waves/waves.min.css">

	<!-- Style.css -->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">

	<!-- Responsive.css-->
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
	<!--color css-->
	<link rel="stylesheet" type="text/css" href="assets/css/color/color-1.min.css" id="color"/>

</head>
<body>
    <?php
    $email = $_GET['verify_email'];
    ?>
	<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
		<div class="container-fluid">
			<div class="row">
				   <div class="col-xs-12">
						<div class="login-card card-block">
						    <?php
                                if($msg!=null)
                                {
                                    ?>
                                    <div class="text-center bg-danger" style="padding:10px;">
                                        <p style="color:#ffffff;"><?php echo $msg; ?></p>
                                    </div>
                                    <?php
                                }
                            ?>
                            <?php
                                if($success!=null)
                                {
                                    ?>
                                    <div class="text-center bg-success" style="padding:10px;">
                                        <p style="color:#ffffff;"><?php echo $success; ?></p>
                                    </div>
                                    <?php
                                }
                            ?>
							<form class="md-float-material" method="POST" id="frmVerification">
								<div class="text-center">
									<img src="assets/images/logo.png" width="100" alt="logo">
								</div>
								<h3 class="text-primary text-center m-b-25">Email Verification</h3>
                                <div class="md-group">
									<div class="md-input-wrapper">
										<input type="email" class="md-form-control" name="email" value="<?php echo $email; ?>"/>
										<label>Email Address</label>
									</div>
								</div>
								<div class="md-group">
									<div class="md-input-wrapper">
										<input type="text" class="md-form-control" id="code" name="code" maxlength="6" minlength="6"/>
										<label>Verification Code</label>
									</div>
								</div>
								<div class="md-group">
								    <input type="submit" class="form-control btn btn-outline-primary" name="btnContinue" value="Submit"/>
								</div>
								<br/>
        						<div class="md-group">
        							<a href="https://jmdormitory.000webhostapp.com/" class="form-control btn btn-primary">Back to Homepage</a>
        						</div>
						<!-- end of btn-forgot class-->
					</form>
					<!-- end of form -->
				</div>
				<!-- end of login-card -->
			</div>
			<!-- end of col-sm-12 -->
		</div>
		<!-- end of row -->
	</div>
	<!-- end of container-fluid -->
</section>

<script src="assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="assets/plugins/tether/dist/js/tether.min.js"></script>

<!-- Required Fremwork -->
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- waves effects.js -->
<script src="assets/plugins/Waves/waves.min.js"></script>

<!-- Custom js -->
<script type="text/javascript" src="assets/pages/elements.js"></script>
</body>
</html>
