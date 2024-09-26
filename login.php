<?php
    session_start();
    include("resources/dbconfig.php");
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        if($_SESSION['sess_role']=="Super-user")
        {
            header("location:admin-panel.php");
        }
        else
        {
            header("location:employee/dashboard.php");
        }
        exit;
    }
    $msg = "";
    if(isset($_POST['btnLogin']))
    {
        try
        {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $stmt = $dbh->prepare("Select Fullname,Designation,Role,adminID from tblaccount WHERE EmailAddress=:email AND Password = SHA1(:password) AND Status=1");
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            $stmt->execute();
            $count = $stmt->rowCount();
            $row   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row))
            {
                $_SESSION['sess_fullname'] = $row['Fullname'];
                $_SESSION['sess_Designation'] = $row['Designation'];
                $_SESSION['sess_role'] = $row['Role'];
                $_SESSION['sess_id'] = $row['adminID'];
                $_SESSION["loggedin"] = true;
                if($row['Role']=="Super-user")
                {
                    header("location:admin-panel.php");
                }
                else
                {
                    header("location:employee/dashboard.php");
                }
                //insert
                $time = $_POST['time'];
                $date = $_POST['date'];
                $datetime = $date." ".$time;
                $stmt = $dbh->prepare("insert into tbl_logs(adminID,DateTime)values(:id,:date)");
                $stmt->bindParam(':id',$row['adminID']);
                $stmt->bindParam(':date',$datetime);
                $stmt->execute();
            }
            else
            {
                $msg = "Invalid Username or Password";
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
	<title>J-M Dormitory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="codedthemes">
	<meta name="keywords"
		  content=", Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
	<meta name="author" content="codedthemes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Favicon icon -->
	<link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
	<link rel="icon" href="assets/images/logo.png" type="image/x-icon">

	<!-- Google font-->
   <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

	<!-- Font Awesome -->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!--ico Fonts-->
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
<section class="login p-fixed d-flex text-center bg-primary">
	<!-- Container-fluid starts -->
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<div class="login-card card-block">
						<div class="text-center">
							<img src="assets/images/logo.png" width="100" alt="logo">
						</div>
						<h3 class="text-center txt-primary">
							Sign In to your account
						</h3>
						<?php
                            if($msg!=null)
                            {
                                ?>
                                <div class="text-center bg-danger" style="padding:10px;">
                                    <p style="color:#ffffff;">Invalid Email Address or Password!</p>
                                </div>
                                <?php
                            }
                        ?>
                        <form class="md-float-material" method="post">
                            <input type="hidden" id="date" name="date"/>
                            <input type="hidden" id="time" name="time"/>
						<div class="row">
							<div class="col-md-12">
								<div class="md-input-wrapper">
									<input type="email" class="md-form-control" name="email" required="required"/>
									<label>Email</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="md-input-wrapper">
									<input type="password" class="md-form-control" name="password" required="required"/>
									<label>Password</label>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
							<div class="rkmd-checkbox checkbox-rotate checkbox-ripple m-b-25">
								<label class="input-checkbox checkbox-primary">
									<input type="checkbox" id="checkbox">
									<span class="checkbox"></span>
								</label>
								<div class="captions">Remember Me</div>

							</div>
								</div>
							<div class="col-sm-6 col-xs-12 forgot-phone text-right">
								<a href="javascript:void(0);" class="text-right f-w-600"> Forget Password?</a>
								</div>
						</div>
						<div class="row">
							<div class="col-xs-10 offset-xs-1">
								<button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" name="btnLogin">LOGIN</button>
							</div>
						</div>
						<!-- <div class="card-footer"> -->
                        <div class="row">
							<div class="col-xs-12 text-center">
								<a href="https://jmdormitory.000webhostapp.com/" class="f-w-600 p-l-5"> Back to Home</a>
							</div>
						</div>
						<!-- </div> -->
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
<script>
    $(document).ready(function()
    {
        today();showTime();
    });
    function today()
    {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        
        var todays = yyyy + '-' + mm + '-'+dd;
        $('#date').val(todays);
    }
    function showTime()
    {
        var date = new Date();
        var h = date.getHours(); 
        var m = date.getMinutes(); 
        var s = date.getSeconds(); 
        var session = "AM";
        
        if(h == 0){
            h = 12;
        }
        
        if(h > 12){
            h = h - 12;
            session = "PM";
        }
        
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;
        
        var times = h + ":" + m + ":" + s + " " + session;
        $('#time').val(times);
        setTimeout(showTime, 1000);
    }
</script>

</body>
</html>
