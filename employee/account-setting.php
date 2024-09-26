<?php
    session_start();
    require_once("../resources/dbconfig.php");
    if(empty($_SESSION['sess_fullname']) || $_SESSION['sess_fullname'] == ''){
    header("Location: https://jmdormitory.000webhostapp.com/");
    die();
}
?>
<?php
$msg = "";$success="";
try
{
    if(isset($_POST['btnChange']))
    {
        $user = $_POST['customer'];
        $current = $_POST['current_pass'];
        $new = $_POST['new_pass'];
        $retype = $_POST['retype_pass'];
        //check the current password
        $stmt=$dbh->prepare("Select * from tblaccount WHERE adminID=:user AND Password= SHA1(:pass)");
        $stmt->bindParam(':user',$user);
        $stmt->bindParam(':pass',$current);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 1 && !empty($row))
        {
              if($new!==$retype)
              {
                  $msg = "Password Mismatched! Try Again";
              }
              else
              {
                  $stmt = $dbh->prepare("update tblaccount SET Password =SHA1(:new) WHERE adminID=:user");
                  $stmt->bindParam(':new',$new);
                  $stmt->bindParam(':user',$user);
                  $stmt->execute();
                  $success= "Password updated!";
              }
        }
        else
        {
            $msg = "Invalid password. Please try again.";
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
    <title>J-M Dormitory Reservation System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="icon" href="../assets/images/logo.png" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="../assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">
    
    <!-- Weather css -->
    <link href="../assets/css/svg-weather.css" rel="stylesheet">


    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
    <style>
        /* Track */
            ::-webkit-scrollbar-track {
              background: #f1f1f1; 
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
              background: #888; 
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
              background: #555; 
            }
            ::-webkit-scrollbar {
                height: 4px;              /* height of horizontal scrollbar ← You're missing this */
                width: 4px;               /* width of vertical scrollbar */
                border: 1px solid #d5d5d5;
              }
            .tableFixHead thead th { position: sticky; top: 0; z-index: 1;color:#fff;background-color:#0275d8;}

                /* Just common table stuff. Really. */
                table  { border-collapse: collapse; width: 100%; }
                th, td { padding: 8px 16px;color:#000; }
                tbody{color:#000;}
            tr:nth-child(even) {
                  background-color: #f2f2f2;
                }

    </style>
</head>

<body class="sidebar-mini fixed">
   <div class="loader-bg">
      <div class="loader-bar">
      </div>
   </div>
   <div class="wrapper">
      <!-- Navbar-->
      <header class="main-header-top hidden-print">
         <a href="dashboard.php" class="logo">
             <img src="../assets/images/logo.png" alt="logo" width="50"/>
             J-M Dormitory
         </a>
         <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu f-right">
               <ul class="top-nav">
                  <!--Notification Menu-->
                  <li class="pc-rheader-submenu">
                     <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                        <i class="icon-size-fullscreen"></i>
                     </a>

                  </li>
                  <!-- User Menu-->
                  <li class="dropdown">
                     <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                        <span><img class="img-circle " src="../assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                        <span><?php echo $_SESSION['sess_fullname']; ?> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="../logout.php"><i class="icon-logout"></i> Logout</a></li>

                     </ul>
                  </li>
               </ul>
         </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print ">
         <section class="sidebar" id="sidebar-scroll">
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="dashboard.php">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="booking.php">
                        <i class="icofont icofont-notebook"></i><span> Booking</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="rooms.php">
                        <i class="icofont icofont-hotel"></i><span> Rooms</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="customer.php">
                        <i class="icofont icofont-people"></i><span> Customer</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="reservation.php">
                        <i class="icofont icofont-address-book"></i><span> Reservation</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="report.php">
                        <i class="icofont icofont-bars"></i><span> Report</span>
                    </a>                
                </li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="account-setting.php">
                        <i class="icofont icofont-user"></i><span> Account</span>
                    </a>                
                </li>
            </ul>
         </section>
      </aside>
      <div class="content-wrapper">
         <!-- Container-fluid starts -->
         <!-- Main content starts -->
         <div class="container-fluid">
            <div class="row">
               <div class="main-header">
                  <h4>Account</h4>
               </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Change Password</div>
                        </div>
                        <div class="card-block">
                            <?php
                            if($msg!=null)
                            {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $msg; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if($success!=null)
                            {
                                ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $success; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <form method="POST" class="row" if="frmPassword">
                                <input type="hidden" name="customer" id="customer" value="<?php echo $_SESSION['sess_id'] ?>"/>
                                <div class="col-md-12 form-group">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control" name="current_pass" id="current_pass" required/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="new_pass" required/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Re-Type Password</label>
                                    <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="retype_pass" required/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="submit" class="btn btn-primary" value="Save Changes"  name="btnChange" id="btnChange"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text"></div>
                        </div>
                        <div class="card-block">
                            <center>
                                <img src="../assets/images/logo.png" width="300"/>
                                <h1>J-M Dormitory Reservation System</h1>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <!-- Main content ends -->
      </div>
   </div>

   <!-- Required Jqurey -->
   <script src="../assets/plugins/Jquery/dist/jquery.min.js"></script>
   <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="../assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- Scrollbar JS-->
   <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="../assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="../../assets/plugins/classie/classie.js"></script>

   <!-- notification -->
   <script src="../assets/plugins/notification/js/bootstrap-growl.min.js"></script>

   <!-- Sparkline charts -->
   <script src="../assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

   <!-- Counter js  -->
   <script src="../assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="../assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- Echart js -->
   <script src="../assets/plugins/charts/echarts/js/echarts-all.js"></script>>

   <!-- custom js -->
   <script type="text/javascript" src="../assets/js/main.min.js"></script>
   <script type="text/javascript" src="../assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="../assets/pages/elements.js"></script>
   <script src="../assets/js/menu.min.js"></script>
    <script>
    var $window = $(window);
    var nav = $('.fixed-button');
    $window.scroll(function(){
        if ($window.scrollTop() >= 200) {
           nav.addClass('active');
        }
        else {
           nav.removeClass('active');
        }
    });
    </script>

</body>

</html>
