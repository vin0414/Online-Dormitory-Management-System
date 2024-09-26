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
                <li class="active treeview">
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
                  <h4>Booking</h4>
               </div>
            </div>
            <div class="row" style="height:600px;">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-text">Filter</div>
                        </div>
                        <div class="card-block">
                            <form method="POST" class="row">
                                <div class="col-lg-12 form-group">
                                    <label>Category</label>
                                    <select class="form-control" id="category">
                                        <option value="">Choose</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>Room Name</label>
                                    <select class="form-control" id="name">
                                        <option value="">Choose</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input type="submit" class="form-control btn btn-primary" id="btnSearch" value="Search"/>
                                </div>
                            </form>
                        </div>
                    </div>   
                </div>
                <div class="col-lg-9">
                    <h5>Select an available room:</h5>
                    <div class="form-group col-md-12" id="tblrooms" style="height:500px;overflow-y:auto;">
                            
                    </div>
                </div>
            </div>
         </div>
         <!-- Main content ends -->
      </div>
   </div>
   <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer's Information</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="row" id="frmCustomer" autocomplete="OFF">
                        <input type="hidden" id="aID" name="aID"/>
                        <input type="hidden" name="action" value="new"/>
                        <div class="col-md-12">
                            <label>Complete Name</label>
                            <input type="text" class="form-control" name="fullname"/>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>Contact No</label>
                                    <input type="phone" class="form-control" name="phone"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="">Choose</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>No. of Bed</label>
                                    <input type="number" class="form-control" name="bed_number" id="bed_number"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>From</label>
                                    <input type="date" class="form-control" name="fromdate" id="fdate"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>To</label>
                                    <input type="date" class="form-control" name="todate" id="tdate"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>No of Months</label>
                                    <input type="text" class="form-control" name="month" id="days"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary" value="Add Customer" id="btnSave"/>
                        </div>
                    </form>
                </div>
            </div>

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
    $(document).ready(function()
    {
       rooms();category();
       $(document).on('click','.reserve',function()
       {
           var val = $(this).val();
           $('#myModal').modal('show');
           $('#aID').attr("value",val);
           
       });
       $('#category').change(function()
       {
           $('#name').find('option').not(':first').remove();
            var action ="get";
            var text = $(this).val();
            $.ajax({
                url:"../resources/employee.php",method:"POST",
                data:{action:action,category:text},
                success:function(data)
                {
                    $('#name').append(data);
                }
            });
       });
    });
    function category()
    {
        var action ="category";
        $.ajax({
            url:"../resources/employee.php",method:"POST",
            data:{action:action},
            success:function(data)
            {
                $('#category').append(data);
            }
        });
    }
    function rooms()
    {
        $('#tblrooms').html("<div><center>Loading Records...</center></div>");
        var action = "available";
        $.ajax({
            url:"../resources/employee.php",method:"POST",
            data:{action:action},
            success:function(data)
            {
                if(data===""){
                    $('#tblrooms').html("<div><center>No Room(s)</center></div>");
                }
                else
                {
                    $('#tblrooms').html(data);
                }
                var count = $('#tblrooms').children('tr').length;$('#totals').html(count);
            }
        });
    }
    $('#btnSearch').on('click',function(evt)
    {
        evt.preventDefault();
        $('#tblrooms').html("<tr><td colspan='6'><center>Searching Records...</center></td></tr>");
        var action = "search-available";
        var name = $('#name').val();
        $.ajax({
            url:"../resources/employee.php",method:"POST",
            data:{action:action,name:name},
            success:function(data)
            {
                if(data===""){
                    $('#tblrooms').html("<tr><td colspan='8'><center>No Room(s)</center></td></tr>");
                }
                else
                {
                    $('#tblrooms').html(data);
                }
                var count = $('#tblrooms').children('tr').length;$('#totals').html(count);
            }
        });
    });
    $('#btnSave').on('click',function(evt)
    {
       evt.preventDefault();
       var data = $('#frmCustomer').serialize();
       $.ajax({
           url:"../resources/connection.php",method:"POST",
           data:data,success:function(data)
           {
               if(data==="Invalid")
               {
                   alert("Oops! Something went wrong");
               }
               else
               {
                   alert("Great! Successfully booked!");
                   $('#frmCustomer')[0].reset();
                   rooms();$('#myModal').modal('hide');
                   window.location.href="billing.php?transaction="+data;
               }
           }
       });
    });
    
    $('#tdate').change(function()
    {
          var dt1 = new Date($('#fdate').val());
          var dt2 = new Date($('#tdate').val());
          var diff =(dt2.getTime() - dt1.getTime()) / 1000;
          diff /= (60 * 60 * 24 * 7 * 4);
          $('#days').attr("value",Math.abs(Math.round(diff)));
    });
    </script>

</body>

</html>
