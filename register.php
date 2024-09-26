<?php
    session_start();
    include("resources/dbconfig.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    $msg="";
    if(isset($_POST['btnRegister']))
    {
        try
        {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug  = 0;  
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;
            $mail->Host       = "smtp.gmail.com";
            $mail->Username   = "jmdormitory2022@gmail.com";
            $mail->Password   = "eoelsredmtpgkcoh";
            
            
            $name = $_POST['fullname'];
            $contact = $_POST['phone'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            $type = "Online";
            $stat = 0;
            $code = random_int(100000, 999999);
            if($password!=$confirm)
            {
                $msg = "Password mismatched! Please try again";
            }
            else
            {
                $sql = "insert into tblcustomer(EmailAddress,Password,Fullname,Contact,Gender,Customer_type,Status,verification)
                values(:email,SHA1(:pass),:name,:contact,:gender,:type,:stat,:code)";
                $stmt=$dbh->prepare($sql);
                $stmt->bindParam(':email',$email);
                $stmt->bindParam(':pass',$password);
                $stmt->bindParam(':name',$name);
                $stmt->bindParam(':contact',$contact);
                $stmt->bindParam(':gender',$gender);
                $stmt->bindParam(':type',$type);
                $stmt->bindParam(':stat',$stat);
                $stmt->bindParam(':code',$code);
                $stmt->execute();
                
                //send email
                $mail->IsHTML(true);
                $mail->AddAddress($email, $name);
                $mail->SetFrom("jmdormitory2022@gmail.com", "J-M Dormitory");
                $mail->AddCC("jmdormitory2022@gmail.com", "J-M Dormitory");
                $mail->Subject = "Verify Email Address";
                $content = "Hi ".$name."!
                            Your verification code is ".$code.".<br/><br/>
                            
                            Enter this code in our website to activate your account.<br/><br/>
                        
                            If you have any questions, send us an email or contact us.<br/><br/>
                            
                            We’re glad you’re here!<br/><br/>
                            J-M Dormitory";
                $mail->MsgHTML($content);
                $mail->Send();
                header("location:verify.php?verify_email=".$email);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $dbh=null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register - J-M Dormitory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="JM Dormitory">
	<meta name="keywords"
	content="JM, J-M Dormitory, Dormitory, J-M">
	<meta name="author" content="codedthemes">

	<!-- Favicon icon -->
	<link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
	<link rel="icon" href="assets/images/logo.png" type="image/x-icon">

	<!-- Google font-->
   <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

	<!--ico Fonts-->
	<link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">

	<!-- Style.css -->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">

	<!-- Responsive.css-->
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">



</head>
<body>
	<section class="login bg-primary">
		<!-- Container-fluid starts -->
		<div class="container-fluid">
			<div class="row">
					<div class="col-sm-12">
						<div class="login-card card-block bg-white">
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
							<form class="md-float-material" method="POST">
								<div class="text-center">
        							<img src="assets/images/logo.png" width="100" alt="logo">
        						</div>
								<h3 class="text-center txt-primary">Create an account </h3>
								<div class="md-input-wrapper">
									<input type="text" class="md-form-control" name="fullname" required="required">
									<label>Complete Name</label>
								</div>
								<div class="md-input-wrapper">
									<input type="email" class="md-form-control" name="email" required="required">
									<label>Email Address</label>
								</div>
								<div class="row">
    								<div class="col-lg-6 form-group">
    								    <div class="md-input-wrapper">
    									    <input type="text" class="md-form-control" name="phone" required="required">
    									    <label>Contact No</label>
    									</div>
    								</div>
    								<div class="col-lg-6 form-group">
    								    <div class="md-input-wrapper">
    									    <select class="md-form-control" name="gender" required="required">
    									        <option value="">Gender</option>
    									        <option>Male</option>
    									        <option>Female</option>
    									    </select>
    									</div>
    								</div>
    							</div>
								<div class="md-input-wrapper">
									<input type="password" class="md-form-control" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
									<label>Password</label>
								</div>
								<div class="md-input-wrapper">
									<input type="password" class="md-form-control" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
									<label>Confirm Password</label>
								</div>

								<div class="rkmd-checkbox checkbox-rotate checkbox-ripple b-none m-b-20">
									<label class="input-checkbox checkbox-primary">
										<input type="checkbox" id="checkbox">
										<span class="checkbox"></span>
									</label>
									<div class="captions">Remember Me</div>
								</div>
								<div class="col-xs-10 offset-xs-1">
									<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light m-b-20" name="btnRegister">Sign up
									</button>
								</div>
								<div class="row">
									<div class="col-xs-12 text-center">
										<span class="text-muted">Already have an account?</span>
										<a href="customer-login.php" class="f-w-600 p-l-5"> Sign In Here</a>

									</div>
								</div>
							</form>
							<!-- end of form -->
						</div>
						<!-- end of login-card -->
					</div>
					<!-- end of col-sm-12 -->
				</div>
				<!-- end of row-->
			</div>
			<!-- end of container-fluid -->
	</section>


   <!-- Required Jqurey -->
   <script src="assets/plugins/jquery/dist/jquery.min.js"></script>
   <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!--text js-->
   <script type="text/javascript" src="assets/pages/elements.js"></script>
</body>
</html>
