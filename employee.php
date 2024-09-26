<?php
    session_start();
    require_once("resources/dbconfig.php");
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
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">
    
    <!-- Weather css -->
    <link href="assets/css/svg-weather.css" rel="stylesheet">


    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
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
         <a href="admin-panel.php" class="logo">
             <img src="assets/images/logo.png" alt="logo" width="50"/>
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
                        <span><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                        <span><?php echo $_SESSION['sess_fullname']; ?> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="logout.php"><i class="icon-logout"></i> Logout</a></li>

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
                    <a class="waves-effect waves-dark" href="admin-panel.php">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>                
                </li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="employee.php">
                        <i class="icofont icofont-users"></i><span> Employee</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="rooms.php">
                        <i class="icofont icofont-hotel"></i><span> Rooms</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="activity-logs.php">
                        <i class="icofont icofont-contacts"></i><span> Activity Logs</span>
                    </a>                
                </li>
                <li class="treeview">
                    <a class="waves-effect waves-dark" href="upload-file.php">
                        <i class="icofont icofont-cloud-upload"></i><span> Upload Files</span>
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
                  <h4>Employee</h4>
               </div>
            </div>
            <div class="row dashboard-header">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Accounts</h5>
                         </div>
                        <div class="card-block">
                            <div class="form-group col-md-12 row">
                                 <label for="search" class="col-12 col-form-label form-control-label">Search</label>
                                 <div class="col-12">
                                    <input class="form-control" type="search" id="search">
                                 </div>
                            </div>
                            <div class="form-group col-md-12 row table-responsive tableFixHead" style="height:400px;overflow-y:auto;font-size:13px;">
                                <table class="table">
                                    <thead>
                                        <th>Employee ID</th>
                                        <th>Complete Name</th>
                                        <th>Designation</th>
                                        <th>Email Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody id="tblemployee"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Add Account</h5>
                        </div>
                        <div class="card-block">
                            <form method="POST" class="row" autocomplete="OFF" id="frmAccount">
                                <div class="col-md-12 form-group">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" name="employeeID"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Fullname</label>
                                    <input type="text" class="form-control" name="fullname"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" name="designation"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>System Role</label>
                                    <select class="form-control" name="role">
                                        <option value="">Choose</option>
                                        <option>Super-user</option>
                                        <option>End-user</option>
                                    </select>
                                </div>
                                <input type="hidden" name="action" value="register"/>
                                <div class="col-md-12 form-group">
                                    <input type="submit" class="form-control btn btn-primary btn-sm" value="Register" id="btnRegister"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
   
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Status</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="row">
                            <div class="col-md-12 form-group">
                                <label>Employee ID</label>
                                <input type="text" class="form-control" id="employeeID"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Status</label>
                                <select class="form-control" id="status">
                                    <option value="">Choose</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="submit" class="form-control btn btn-primary" id="btnSubmit" value="Submit"/>
                            </div>
                        </form>
                    </div>
            </div>

        </div>
    </div>

   <!-- Required Jqurey -->
   <script src="assets/plugins/Jquery/dist/jquery.min.js"></script>
   <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- Scrollbar JS-->
   <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="assets/plugins/classie/classie.js"></script>

   <!-- notification -->
   <script src="assets/plugins/notification/js/bootstrap-growl.min.js"></script>

   <!-- Sparkline charts -->
   <script src="assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

   <!-- Counter js  -->
   <script src="assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- Echart js -->
   <script src="assets/plugins/charts/echarts/js/echarts-all.js"></script>

   <!-- custom js -->
   <script type="text/javascript" src="assets/js/main.min.js"></script>
   <script type="text/javascript" src="assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="assets/pages/elements.js"></script>
   <script src="assets/js/menu.min.js"></script>
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
        loadEmployee();
        $(document).on('click','.update',function()
        {
           var val = $(this).val();
           $('#myModal').modal('show');
           $('#employeeID').attr("value",val);
        });
        
        $('#btnSubmit').on('click',function(evt)
        {
           evt.preventDefault();
           var action = "update-employee";
           var id = $('#employeeID').val();
           var stat = $('#status').val();
           $.ajax({
               url:"resources/processing.php",method:"POST",
               data:{action:action,employee:id,status:stat},
               success:function(data)
               {
                   alert(data);loadEmployee();
                   $('#myModal').modal('hide');
               }
           });
        });
    });
    function loadEmployee()
    {
        var action = "accounts";
        $('#tblemployee').html("<tr><td colspan='6'><center>Loading records....</center></td></tr>"); 
        $.ajax({
               url:"resources/processing.php",method:"POST",
               data:{action:action},
               success:function(data)
               {
                   if(data==="")
                   {
                       $('#tblemployee').html("<tr><td colspan='6'><center>No Account(s)</center></td></tr>"); 
                   }
                   else
                   {
                       $('#tblemployee').html(data); 
                   }
               }
           });
    }
    $('#search').keyup(function()
    {
        var action = "search-accounts";
        var text = $(this).val();
        $('#tblemployee').html("<tr><td colspan='6'><center>Searching....</center></td></tr>"); 
        $.ajax({
               url:"resources/processing.php",method:"POST",
               data:{action:action,keyword:text},
               success:function(data)
               {
                   if(data==="")
                   {
                       $('#tblemployee').html("<tr><td colspan='6'><center>No Account(s)</center></td></tr>"); 
                   }
                   else
                   {
                       $('#tblemployee').html(data); 
                   }
               }
           });
    });
    
    $('#btnRegister').on('click',function(evt)
    {
        evt.preventDefault();
        var data = $('#frmAccount').serialize();
        $.ajax({
               url:"resources/processing.php",method:"POST",
               data:data,
               success:function(data)
               {
                   if(data==="success")
                   {
                       loadEmployee();
                       $('#frmAccount')[0].reset();
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
