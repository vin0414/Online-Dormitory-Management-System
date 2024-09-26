<?php
    session_start();
    require_once("../resources/dbconfig.php");
    if(empty($_SESSION['sess_fullname']) || $_SESSION['sess_fullname'] == ''){
    header("Location: https://jmdormitory.000webhostapp.com/");
    die();
}
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
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="javascript:void(0);">
                        <i class="icofont icofont-bill"></i><span> Pay Balance</span>
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
                <li class="treeview">
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
                  <h4>Pay Balance</h4>
               </div>
            </div>
            <?php 
                $code = $_GET['QRCode'];
            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card">
                            <div class="card-block">
                                <?php
                                try
                                {
                                    $stmt = $dbh->prepare("Select FORMAT(a.Change_Amount,2)Balance,FORMAT(b.TotalCharge,2)total,d.Fullname,e.RoomNumber,FORMAT(f.Rate,2)Rate,a.Month from tbl_bill a 
                                    LEFT JOIN tblpayment b ON b.QRCode=a.QRCode 
                                    LEFT JOIN tbltransaction c ON c.trxnID=b.trxnID 
                                    LEFT JOIN tblcustomer d ON d.customerID=c.customerID 
                                    LEFT JOIN tblavailableroom e ON e.aID=c.aID 
                                    LEFT JOIN tblrooms f ON f.roomID=e.roomID WHERE a.QRCode=:code GROUP BY a.billID DESC LIMIT 1");
                                    $stmt->bindParam(':code',$code);
                                    $stmt->execute();
                                    $data = $stmt->fetchAll();
                                    foreach($data as $row)
                                    {
                                        ?>
                                        <form method="post" class="row" id="frmPay">
                                            <input type="hidden" id="code" name="code" value="<?php echo $code ?>"/>
                                            <input type="hidden" id="action" name="action" value="paying-balance"/>
                                            <div class="col-md-12">
                                                <h6 class="form-control">Customer Details</h6>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>Customer's Name</label>
                                                <input type="text" class="form-control" value="<?php echo $row['Fullname'] ?>" readonly/>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Room No.</label>
                                                        <input type="text" class="form-control" value="<?php echo $row['RoomNumber'] ?>" readonly/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Room Rate</label>
                                                        <input type="text" class="form-control" value="<?php echo $row['Rate'] ?>" style="text-align:right;" readonly/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Total</label>
                                                        <input type="text" class="form-control" value="<?php echo $row['total'] ?>" name="total" style="text-align:right;" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <h6 class="form-control">Remaining</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Month</label>
                                                        <input type="text" class="form-control" name="month" value="<?php echo $row['Month'] ?>" readonly/>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label>Balance</label>
                                                        <input type="text" class="form-control" name="balance" id="balance" value="<?php echo $row['Balance'] ?>" style="text-align:right;" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Month</label>
                                                        <select class="form-control" id="month" name="remain_month">
                                                            <option value="">Choose</option>
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>12</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label>Amount Rendered</label>
                                                        <input type="text" class="form-control" style="text-align:right;" placeholder="0.00" id="amount" name="amount"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>Remaining Balance</label>
                                                <input type="text" class="form-control" style="text-align:right;" placeholder="0.00" name="change" id="change" readonly/>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <button type="submit" class="btn btn-primary form-control" id="btnSave">Submit Payment</button>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                                catch(Exception $e)
                                {
                                    echo $e->getMessage();
                                }
                                $dbh=null;
                                ?>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-3"></div>
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
    $('#amount').keyup(function()
    {
        var val = $(this).val();
        var charge = $('#balance').val();
        var amt = charge.replace(/,/g, '');
        var returnAmount = amt-val;
        $('#change').attr("value",returnAmount);
    });
    $('#btnSave').on('click',function(evt)
    {
        evt.preventDefault();
        var data = $('#frmPay').serialize();
        $.ajax({
            url:"../resources/paying.php",method:"POST",
            data:data,success:function(data)
            {
                if(data==="success")
                {
                    var confirmation = confirm("Successfully submitted. Do you want to print receipt?");
                    if(confirmation)
                    {
                        window.open("print.php?QRCode=<?php echo $code ?>");
                    }
                    else
                    {
                        window.location.href="customer.php";
                    }
                }
                else
                {
                    alert(data);
                }
            }
        });
    });
</script>

</body>

</html>
