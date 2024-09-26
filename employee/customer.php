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
                <li class="active treeview">
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
                  <h5 id="dates"></h5>
                  <h6 id="times"></h6>
               </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">QR Code Scanner</div>
                        </div>
                        <div class="card-block">
                            <form method="POST" class="row">
                                <input type="hidden" id="date"/>
                                <input type="hidden" id="time"/>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" id="process">
                                        <option value="">Choose</option>
                                        <option>Time In</option>
                                        <option>Time Out</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="form-control" style="" id="reader"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Details : </div>
                            <div id="result">
                                <div><center>Waiting for scanning process...</center></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Customer's Information</div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Search</label>
                                    <input type="search" class="form-control" id="search"/>
                                </div>
                                <div class="col-md-12 form-group table-responsive tableFixHead" style="height:500px;overflow-y:auto;">
                                    <table class="table">
                                        <thead>
                                            <th>Customer's Name</th>
                                            <th>Room No.</th>
                                            <th>Description</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody id="tblcustomer"></tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <p style="float:right;">Total : <button type="button" id="total" class="btn btn-default"></button></p>
                                </div>
                            </div>
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
   <script src="../assets/js/html5-qrcode.min.js"></script>
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
    $(document).ready(function()
    {
        loadCustomer();today();showTime();
    });
    function today()
    {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        
        var todays = yyyy + '-' + mm + '-'+dd;
        $('#date').val(todays);
        $('#dates').html(todays);
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
        $('#times').html(times);
        setTimeout(showTime, 1000);
    }
    function loadCustomer()
    {
        $('#tblcustomer').html("<tr><td colspan='6'><center>Loading...</center></td></tr>");
        var action = "customer";
        $.ajax({
            url:"../resources/employee.php",method:"POST",
            data:{action:action},
            success:function(data)
            {
                if(data==="")
                {
                    $('#tblcustomer').html("<tr><td colspan='6'><center>No Customer(s)</center></td></tr>");
                }
                else
                {
                    $('#tblcustomer').html(data);
                }
                var count = $('#tblcustomer').children('tr').length;$('#total').html(count);
            }
        });
    }
    
    $('#search').keyup(function()
    {
        $('#tblcustomer').html("<tr><td colspan='6'><center>Searching...</center></td></tr>");
        var action = "search-customer";
        var text = $(this).val();
        $.ajax({
            url:"../resources/employee.php",method:"POST",
            data:{action:action,keyword:text},
            success:function(data)
            {
                if(data==="")
                {
                    $('#tblcustomer').html("<tr><td colspan='6'><center>No Customer(s)</center></td></tr>");
                }
                else
                {
                    $('#tblcustomer').html(data);
                }
                var count = $('#tblcustomer').children('tr').length;$('#total').html(count);
            }
        });
    });
    $(document).on('click','.checkout',function()
    {
        var confirmation = confirm("Do you want to check out?");
        if(confirmation)
        {
            var val = $(this).val();
            var action = "check-out";
            $.ajax({
                url:"../resources/employee.php",method:"POST",
                data:{action:action,id:val},
                success:function(data)
                {
                    alert(data);
                    loadCustomer();
                }
            });
        }
        
    });
    </script>
    <script type="text/javascript">
        function onScanSuccess(qrCodeMessage) {
            var code = qrCodeMessage;
            var proc = $('#process').val();
            var date = $('#date').val();
            var time = $('#time').val();
            var action = "scan";
            $.ajax({
                url:"../resources/connection.php",
                method:"POST",
                data:{action:action,code:code,process:proc,date:date,time:time},
                success:function(data)
                {
                    $('#result').html(data);
                }
            });
        }
        function onScanError(errorMessage) {
          //handle scan error
        }
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>

</body>

</html>
